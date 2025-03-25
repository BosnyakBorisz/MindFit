<?php
    // DeepL API kulcsod
    $api_key = '';

    // A fordítandó szöveg
    $clean_workout_plan = "<table class='workout-table'>
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
                    <td>Barbell Bench Press</td>
                    <td>4</td>
                    <td>8-12</td>
                    <td>60s</td>
                </tr>
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
                    <td>Incline Barbell Bench Press</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
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
                    <td>Dumbbell Flyes</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
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
                    <td>Bodyweight Rows</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
            </tbody>
        </table>

        <h2>Tuesday</h2>
        <table class='workout-table'>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Rest</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Barbell Bentover Rows</td>
                    <td>4</td>
                    <td>8-12</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Wide-Grip Pull-ups</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Seated Cable Rows</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Bodyweight Planks</td>
                    <td>3</td>
                    <td>30s-1min</td>
                    <td>30s</td>
                </tr>
            </tbody>
        </table>

        <h2>Wednesday (Active Rest Day)</h2>
        <table class='workout-table'>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Rest</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bodyweight Squats</td>
                    <td>3</td>
                    <td>15-20</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Step-ups on Chair with Dumbbells</td>
                    <td>3</td>
                    <td>15-20</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Bodyweight Lunges</td>
                    <td>3</td>
                    <td>15-20</td>
                    <td>60s</td>
                </tr>
            </tbody>
        </table>

        <h2>Thursday</h2>
        <table class='workout-table'>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Rest</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Close-grip Barbell Bench Press</td>
                    <td>4</td>
                    <td>8-12</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Dumbbell Skull Crushers</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
            </tbody>
        </table>

        <h2>Friday</h2>
        <table class='workout-table'>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Rest</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bent-over Barbell Row</td>
                    <td>4</td>
                    <td>8-12</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Seated Dumbbell Tricep Extension</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Push-ups</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
            </tbody>
        </table>

        <h2>Saturday</h2>
        <table class='workout-table'>
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Rest</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bodyweight Dips</td>
                    <td>4</td>
                    <td>8-12</td>
                    <td>60s</td>
                </tr>
                <tr>
                    <td>Barbell Curls</td>
                    <td>3</td>
                    <td>12-15</td>
                    <td>60s</td>
                </tr>
            </tbody>
        </table>    
    </div>";


    $dictionary = [
        'Completed' => 'Kész',
        'Exercise' => 'Gyakorlat',
        'Sets' => 'Szettek',
        'Reps' => 'Ismétlés',
        'Rest' => 'Pihenő',
        'Monday' => 'Hétfő',
        'Tuesday' => 'Kedd',
        'Wednesday' => 'Szerda', 
        'Thursday' => 'Csütörtök',
        'Friday' => 'Péntek',
        'Saturday' => 'Szombat',
        'Sunday' => 'Vasárnap',
        'Barbell Bench Press' => 'Fekvenyomás',
        'Incline Barbell Bench Press' => 'Döntött pados fekvenyomás',
        'Dumbbell Flyes' => 'Tárogatás súlyzóval',
        'Barbell Bentover Rows' => 'Döntött törzsű evezés rúddal',
        'Wide-Grip Pull-ups' => 'Széles fogású húzódzkodás',
        'Seated Cable Rows' => 'Evezés kábellel ülve',
        'Bodyweight Planks' => 'Plank (testsúlyos)',
        'Bodyweight Squats' => 'Testsúlyos guggolás',
        'Step-ups on Chair with Dumbbells' => 'Lépcsőzés kézi súlyzókkal',
        'Bodyweight Lunges' => 'Kitörés',
        'Close-grip Barbell Bench Press' => 'Szűk fogású fekvenyomás',
        'Dumbbell Skull Crushers' => 'Súlyzós tricepsznyújtás',
        'Seated Dumbbell Tricep Extension' => 'Ülő sulyzós tricepsznyújtás',
        'Push-ups' => 'Fekvőtámasz',
        'Bodyweight Dips' => 'Testsúlyos tolóckodás',
        'Barbell Curls' => 'Sulyzós bicepsz hajltás',
        'Hammer Curls' => 'Kalapács bicepsz hajlítás',
        'Leg Press' => 'Lábtoló',
        'Lat Pulldown' => 'Széles fogású lehúzás',
        'Seated Leg Curl' => 'Ülő combhajlító',
        'Leg Extension' => 'Combfeszítő',
        'Deadlift' => 'Felhúzás',
        'Romanian Deadlift' => 'Román felhúzás',
        'Kettlebell Swings' => 'Gömbsúlyzó hintázás',
        'Standing Calf Raises' => 'Álló vádliemelés',
        'Seated Calf Raises' => 'Ülő vádliemelés',
        'Overhead Shoulder Press' => 'Vállból nyomás rúddal',
        'Lateral Raises' => 'Oldalsó emelés',
        'Front Raises' => 'Elülső emelés',
        'Rear Delt Flyes' => 'Hátsó váll repülés',
        'Bicep Curls' => 'Bicepsz hajlítás',
        'Tricep Dips' => 'Tricepsz lenyomás',
        'Chest Flyes' => 'Mellkas repülés',
        'Chest Press' => 'Mellkas nyomás',
        'Hip Thrust' => 'Csípőemelés',
        'Leg Curl' => 'Lábhajlítás',
        'Crunches' => 'Felülés',
        'Russian Twists' => 'Orosz csavarás',
        'Mountain Climbers' => 'Hegymászó',
        'Burpees' => 'Burpee',
        'Jumping Jacks' => 'Táncos ugrás',
        'Squat Jumps' => 'Guggolás ugrás',
        'Box Jumps' => 'Doboz ugrás',
        'Plank to Push-up' => 'Plank fekvőtámaszra',
        'Wall Sit' => 'Fal mellett ülés',
        'Leg Raises' => 'Lábemelés',
        'Flutter Kicks' => 'Pillangó rúgás',
        'V-Ups' => 'V-ülés',
        'Hanging Leg Raises' => 'Függő lábemelés',
        'Incline Dumbbell Press' => 'Döntött dumbbell nyomás',
        'Decline Bench Press' => 'Lejtős fekvenyomás',
        'Reverse Flyes' => 'Fordított repülés',
        'Cable Kickbacks' => 'Kábel tricepsz lenyomás',
        'Tricep Kickbacks' => 'Tricepsz rúgás',
        'Dumbbell Rows' => 'Dumbbell evezés',
        'T-Bar Rows' => 'T-bar evezés',
        'Shrugs' => 'Vállvonogatás',
        'Good Mornings' => 'Jó reggelt gyakorlat',
        'Jump Rope' => 'Ugró kötél',
    ];

    function translate($text, $dictionary) {
        foreach ($dictionary as $english => $hungarian) {
            $text = str_replace($english, $hungarian, $text);
        }
        return $text;
    }
    
    $workout_plan = translate($clean_workout_plan, $dictionary);

    // DeepL API endpoint
    $url = 'https://api-free.deepl.com/v2/translate';

    // API kérés adatainak előkészítése
    $data = [
        'auth_key' => $api_key,
        'text' => $workout_plan,
        'source_lang' => 'EN',
        'target_lang' => 'HU'
    ];

    // CURL kérés inicializálása
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // API válasz megkapása
    $response = curl_exec($ch);
    curl_close($ch);

    // Hiba ellenőrzése
    if ($response === false) {
        die("Error with cURL: " . curl_error($ch));
    }

    // A válasz dekódolása
    $response_data = json_decode($response, true);
    if (isset($response_data['translations'][0]['text'])) {
        // Fordított szöveg
        $translated_workout_plan = $response_data['translations'][0]['text'];
        
    } else {
        die("Hiba a válaszban: " . json_encode($response_data));
    }

    
?>

<!DOCTYPE html>
<html lang="en">
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
    <div class="d-flex align-items-center flex-column">
        <?php
            echo $translated_workout_plan;
        ?>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.exerciseCheckbox');

            checkboxes.forEach((checkbox) => {
                const checkboxId = checkbox.getAttribute('data-id');
                const savedState = localStorage.getItem(`exerciseCheckbox${checkboxId}`);
                
                if (savedState === 'checked') {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }

                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        localStorage.setItem(`exerciseCheckbox${checkboxId}`, 'checked');
                    } else {
                        localStorage.setItem(`exerciseCheckbox${checkboxId}`, 'unchecked');
                    }
                });
            });
        });

    </script>
</body>
</html>