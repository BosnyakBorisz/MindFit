<?php

    session_start();

    if (!isset($_SESSION["email"])){
        header("Location: login.php");
        exit();
    }

    include("database.php");

    $email = $_SESSION["email"];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        session_destroy();
    } 
    
    if (isset($_POST['ujrageneral'])) {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userID = $user['id'];
        } 

        $stmt->close();

        $stmt = $conn->prepare("SELECT nem, kor, testsuly, magassag, cel, testalkat, jelenlegi_testzsir, cel_testzsir, jelenlegi_edzes_per_het, kivant_edzes_per_het, kivant_edzes_hossza, edzes_helye, felszereltseg, fokuszalt_izomcsoport, serult_testrész FROM user_information WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_data = json_encode($user,  JSON_UNESCAPED_UNICODE);
        } else {
            die("Nincs ilyen felhasználó.");
        }
    
        $stmt->close();

        // Edzésterv létrehozása az AI API segítségével
        $api_url = "https://api-inference.huggingface.co/models/mistralai/Mistral-Small-24B-Instruct-2501";
        $api_key = ""; // Hugging Face API token
                
        $data = json_encode([
            "inputs" => "Generate a structured {$user['kivant_edzes_per_het']}-day hypertrophy workout plan for a {$user['kor']}-year-old {$user['nem']} who weighs {$user['testsuly']} kg, is {$user['magassag']} cm tall, and aims to {$user['cel']}. His current body fat percentage is {$user['jelenlegi_testzsir']}, with a target of {$user['cel_testzsir']}. 

            The workout plan should be designed for {$user['kivant_edzes_per_het']} days per week, with each session lasting {$user['kivant_edzes_hossza']} minutes. Training will take place at {$user['edzes_helye']}, with available equipment being {$user['felszereltseg']}. 

            The plan should prioritize the following muscle groups: {$user['fokuszalt_izomcsoport']}, while considering any injuries: {$user['serult_testrész']}. 

            Each day there is only 2 muscle group OR an upper lower body workout.

            The workout days should consist of two or three muscle groups per day.
            No muscle group should be worked two days in a row. Ensure that each muscle group gets a day off between workouts.

            Muscle groups:
            - Chest
            - Back
            - Abs
            - Shoulder
            - Biceps
            - Triceps
            - Quads
            - Hamstring
            - Calves

            - For each exercise, provide the following:
                - **Exercise Name** (e.g., Barbell Squat)
                - **Sets** (e.g., 4)
                - **Reps** (e.g., 8-12)
                - **Rest** (e.g., 60s)
            - Ensure to do not exceed the time limit.
                
            **DO NOT** include any comments, instructions, or suggestions beyond the workout plan.
            
            Example Structure:
            <h2>Name of the day</h2>
            <table class='workout-table'>
                <thead>
                    <tr>
                        <th>Completed</th>
                        <th>Exercise</th>
                        <th>Sets</th>
                        <th>Reps</th>
                        <th>Rest</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class='kisebb'>
                        <div class='checkbox-wrapper-44 d-flex justify-content-center'>
                            <label class='toggleButton'>
                                <input type='checkbox' class='exerciseCheckbox' data-id='1'>
                                <div>
                                    <svg viewBox='0 0 44 44'>
                                        <path d='M14,24 L21,31 L39.7428882,11.5937758 C35.2809627,6.53125861 30.0333333,4 24,4 C12.95,4 4,12.95 4,24 C4,35.05 12.95,44 24,44 C35.05,44 44,35.05 44,24 C44,19.3 42.5809627,15.1645919 39.7428882,11.5937758' transform='translate(-2.000000, -2.000000)'></path>
                                    </svg>
                                </div>
                            </label>
                        </div>  
                        </td>
                        <td>Deadlift</td>
                        <td>4</td>
                        <td>8-12</td>
                        <td>60s</td>
                    </tr>
                    <!-- More exercises for the day here -->
                </tbody>
            </table>
        
            ONLY RETURN the generated workout plan in HTML format without any additional text, comments, or instructions."
        ]);

        $promptLength = strlen($data);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        
        if ($response === false) {
            die("Nem sikerült edzéstervet generálni.");
        }
        
        // Debugging: Output the response
        echo "API Response: " . $response;
            
        // Decode the JSON response
        $data = json_decode($response, true);
        
        // Check if the AI response contains the necessary data
        if (!isset($data[0]['generated_text'])) {
            die("Nem sikerült edzéstervet generálni.");
        }
        
        // Extracting the raw workout plan
        $workout_plan = $data[0]['generated_text'];
        
        // Clean the workout plan by removing the prompt part
        $clean_workout_plan = substr($workout_plan, strlen($data[0]['generated_text']));
        
        // Output the clean workout plan
        echo $clean_workout_plan;
        $lines = file('translations.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $translations = [];
        
        foreach ($lines as $index => $line) {
            if (preg_match('/["\'](.+?)["\']\s*=>\s*["\'](.*?)["\'],?/', $line, $matches)) {
                $key = $matches[1];
                $value = $matches[2];
                $translations[$key] = $value;
            }
        }
        
    
        function translate($text, $translations) {
            foreach ($translations as $english => $hungarian) {
                $text = str_replace($english, $hungarian, $text);
            }
            return $text;
        }
        
        $translated_workout_plan = translate($clean_workout_plan, $translations);

        // Edzésterv mentése
        if (!empty($translated_workout_plan)){
            $stmt = $conn->prepare("INSERT INTO user_workout_plan (user_id, plan) VALUES (?, ?)");
            $stmt->bind_param("is", $userID, $translated_workout_plan);

            if (!$stmt->execute()) {
                die("Hiba: Nem sikerült elmenteni az edzéstervet.");
            }
        }

       exit();

    }

    $stmt = $conn->prepare("
    SELECT user_workout_plan.plan 
    FROM user_workout_plan 
    JOIN users ON users.id = user_workout_plan.user_id 
    WHERE users.email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($workout_plan);
    

?>  
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Edzésterv</title>
    <link rel="icon" href="img/strong.png"></link:icon>
</head>
<body>
  
    <?php
      include("header.html")
    ?>

    <div class="d-flex align-items-center flex-column">
        <?php
            if ($stmt->fetch()) {
                echo $workout_plan;
            } else {
                echo "Nem található edzésterv.";
                echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">
                        <button class="btn btn-light" type="submit" name="ujrageneral">Edzésterv újragenerálása</button>
                    </form>';
            }
            $stmt->close();
        ?>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkbox = document.getElementById('exerciseCheckbox1');

            const savedState = localStorage.getItem('exerciseCheckbox1');
            if (savedState === 'checked') {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    localStorage.setItem('exerciseCheckbox1', 'checked');
                } else {
                    localStorage.setItem('exerciseCheckbox1', 'unchecked');
                }
            });
        });
    </script>
    
</body>
</html>