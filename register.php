<?php

    session_start();

    if (isset($_SESSION["email"])) {
        header("Location: profil.php");
        exit();
    }

    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $username = trim($_POST["username"]);
        $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
        $password = trim($_POST["password"]);


        if (empty($username) || empty($email) || empty($password)) {
            die("Az összes mezőt ki kell tölteni!");
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            die("Az email már használatban van!");
        }
        $stmt->close();

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (felhasznnev, email, jelszo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);
        if (!$stmt->execute()) {
            die("Adatbázis hiba: ");
        }
        $userID = $stmt->insert_id;
        $_SESSION["user_id"] = $userID;

        $stmt->close();

        $sex = trim($_POST['sex']);
        $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
        $weight = filter_var($_POST['weight'], FILTER_VALIDATE_FLOAT);
        $height = filter_var($_POST['height'], FILTER_VALIDATE_FLOAT);
        $goal = trim($_POST['goal']);
        $bodytype = trim($_POST['bodytype']);

        $currentBodyfatValue = filter_var($_POST['bodyfat-range'], FILTER_VALIDATE_INT);
        $goalBodyfatValue = filter_var($_POST['bodyfat-range2'], FILTER_VALIDATE_INT);
        $currentBodyfat = $currentBodyfatValue * 5;
        $goalBodyfat = $goalBodyfatValue * 5;

        $workoutFrequency = trim($_POST['workout-frequency']);
        $wantedWorkoutFrequency = filter_var($_POST['wanted-workout-frequency'], FILTER_VALIDATE_INT);
        $wantedWorkoutTime = filter_var($_POST['wanted-workout-time'], FILTER_VALIDATE_INT);
        $workoutPlace = trim($_POST['edzeshelye']);
        $equipment = trim($_POST['felszereltseg']);
        $focusedMuscle = isset($_POST['fokuszaltizomcsoport']) ? implode(', ', $_POST['fokuszaltizomcsoport']) : 'none';
        $injured = isset($_POST['injured']) ? implode(', ', $_POST['injured']) : 'none';   

        $stmt = $conn->prepare("INSERT INTO user_information 
            (user_id, nem, kor, testsuly, magassag, cel, testalkat, jelenlegi_testzsir, cel_testzsir, jelenlegi_edzes_per_het, kivant_edzes_per_het, kivant_edzes_hossza, edzes_helye, felszereltseg, fokuszalt_izomcsoport, serult_testrész)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("isiiissiiiiissss", 
            $userID, $sex, $age, $weight, $height, $goal, $bodytype, 
            $currentBodyfat, $goalBodyfat, $workoutFrequency, 
            $wantedWorkoutFrequency, $wantedWorkoutTime, $workoutPlace, 
            $equipment, $focusedMuscle, $injured
        );

        if (!$stmt->execute()) {
            die("Adatbázis hiba");
        }


        $stmt->close();

        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;

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
        $api_url = "https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.3";
        $api_key = ""; // Hugging Face API token
                
        $data = json_encode([
            "inputs" => "Generate a structured {$wantedWorkoutFrequency}-day hypertrophy workout plan for a {$age}-year-old man who weighs {$weight} kg, is {$height} cm tall, and aims to {$goal}. His current body fat percentage is {$currentBodyfat}, with a target of {$goalBodyfat}. 
        
            The workout plan should be designed for {$wantedWorkoutFrequency} days per week, with each session lasting {$wantedWorkoutTime} minutes. Training will take place at {$workoutPlace}, with available equipment being {$equipment}. 
        
            The plan should prioritize the following muscle groups: {$focusedMuscle}, while considering any injuries: {$injured}. 

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

        
        
        $options = [
            "http" => [
                "header" => "Authorization: Bearer " . $api_key . "\r\n" .
                            "Content-Type: application/json\r\n",
                "method" => "POST",
                "content" => $data
            ]
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);
        if ($response === false) {
            $error = error_get_last();
            die("Nem sikerült edzéstervet generálni. Hiba: " . $error['message']);
        }
        
        if ($response === false) {
            die("Nem sikerült edzéstervet generálni.");
        }
        
        // AI API response is stored in $response
        $data = json_decode($response, true);

        // Check if the AI response contains the necessary data
        if (!isset($data[0]['generated_text'])) {
            die("Nem sikerült edzéstervet generálni.");
        }

        // Extracting the raw workout plan
        $workout_plan = $data[0]['generated_text'];

        // Clean the workout plan by removing the prompt part
        
        $clean_workout_plan = $workout_plan;

        $dictionary = [
            'Completed' => 'Kész',
            'Exercise' => 'Gyakorlat',
            'Sets' => 'Szettek',
            'Reps' => 'Ismétlés',
            'Rest' => 'Pihenő',
            'Active' => 'Aktív',
            'Day' => 'Nap',
            'Monday' => 'Hétfő',
            'Tuesday' => 'Kedd',
            'Wednesday' => 'Szerda', 
            'Thursday' => 'Csütörtök',
            'Friday' => 'Péntek',
            'Saturday' => 'Szombat',
            'Sunday' => 'Vasárnap',
            'Day' => 'Nap',
            'Close-grip Barbell Bench Press' => 'Szűk fogású fekvenyomás',
            'Barbell Bench Press' => 'Fekvenyomás',
            'Incline Barbell Bench Press' => 'Döntött pados fekvenyomás',
            'Dumbbell Flyes' => 'Tárogatás kézisúlyzóval',
            'Barbell Bentover Rows' => 'Döntött törzsű evezés rúddal',
            'Wide-Grip Pull-ups' => 'Széles fogású húzódzkodás',
            'Seated Cable Rows' => 'Evezés kábellel ülve',
            'Bodyweight Planks' => 'Plank',
            'Bodyweight Squats' => 'Sajáttestsúlyos guggolás',
            'Bodyweight Lunges' => 'Kitörés',
            'Dumbbell Skull Crushers' => 'kézisúlyzós tricepsznyújtás(koponyatörés)',
            'Seated Dumbbell Tricep Extension' => 'Ülő súlyzós tricepsznyújtás',
            'Push-ups' => 'Fekvőtámasz',
            'Bodyweight Dips' => 'Testsúlyos tolóckodás',
            'Barbell Curls' => 'Sulyzós bicepsz hajlitás',
            'Hammer Curls' => 'Kalapács bicepsz hajlítás',
            'Leg Press' => 'Lábtoló',
            'Lat Pulldown' => 'Széles fogású lehúzás',
            'Seated Leg Curl' => 'Ülő combhajlító',
            'Leg Extension' => 'Combfeszítő',
            'Deadlift' => 'Felhúzás',
            'Romanian Deadlift' => 'Román felhúzás',
            'Kettlebell Swings' => 'Gömbsúlyzó lendités',
            'Standing Calf Raises' => 'Álló vádliemelés',
            'Seated Calf Raises' => 'Ülő vádliemelés',
            'Overhead Shoulder Press' => 'Vállból nyomás rúddal',
            'Lateral Raises' => 'Oldalsó emelés',
            'Front Raises' => 'Elülső emelés',
            'Rear Delt Flyes' => 'Hátsó vállra tárogatás',
            'Bicep Curls' => 'Bicepsz hajlítás',
            'Tricep Dips' => 'Tricepsz lenyomás',
            'Chest Flyes' => 'Tárogatás',
            'Chest Press' => 'géppel nyomás',
            'Hip Thrust' => 'Csípőemelés',
            'Leg Curl' => 'Lábhajlítás',
            'Crunches' => 'Felülés',
            'Russian Twists' => 'Orosz csavarás',
            'Mountain Climbers' => 'Helyben futás fekvőtámaszban',
            'Burpees' => 'Négyütemü felvőtámasz',
            'Jumping Jacks' => 'Terpesz-zár',
            'Squat Jumps' => 'Guggolás ugrás',
            'Box Jumps' => 'Dobozra ugrás',
            'Plank to Push-up' => 'Plank fekvőtámaszba',
            'Wall Sit' => 'Fal mellett ülés',
            'Leg Raises' => 'Lábemelés',
            'Flutter Kicks' => 'Pillangó rúgás',
            'V-Ups' => 'V-ülés',
            'Hanging Leg Raises' => 'Függő lábemelés',
            'Incline Dumbbell Press' => 'Döntött kézisúlyzóval nyomás',
            'Decline Bench Press' => 'Lefelé döntött fekvenyomás',
            'Cable Kickbacks' => 'Csigás tricepsz lenyomás',
            'Tricep Kickbacks' => 'Tricepsz nyújtás(lórugás)',
            'Dumbbell Rows' => 'Dumbbell evezés',
            'T-Bar Rows' => 'T-bar rúddal evezés',
            'Shrugs' => 'Vállvonogatás',
            'Good Mornings' => 'Jó reggelt gyakorlat',
            'Jump Rope' => 'Ugró kötél',
            "kettlebell swing" => "kettlebell lendítés",
            "medicine ball slam" => "gyógylabda csapás",
            "battle ropes" => "kötélcsapkodás",
            "farmers carry" => "farmer séta",
            "sled push" => "szán tolás",
            "sled pull" => "szán húzás",
            "Turkish get-up" => "török felállás",
            "box step-over" => "doboz átlépés",
            "power clean" => "erőemelés",
            "clean and jerk" => "zaklatás és lökés",
            "snatch" => "szakítás",
            "muscle-up" => "muscle-up",
            "front squat" => "mellső guggolás",
            "overhead squat" => "fejlőtti guggolás",
            "zercher squat" => "zercher guggolás",
            "jump rope" => "ugrókötél",
            "skater jump" => "korcsolyázó ugrás",
            "boxer shuffle" => "bokszoló szökdelés",
            "shadowboxing" => "árnyékboksz",
            "clap push-up" => "tapsos fekvőtámasz",
            "arch hold" => "ívtartás",
            "wall walk" => "falon járás",
            "handstand" => "kézállás",
            "handstand push-up" => "kézállásos fekvőtámasz",
            "wall ball" => "labdadobás falhoz",
            "dumbbell snatch" => "kézisúlyzós szakítás",
            "dumbbell thruster" => "kézisúlyzós guggolás-nyomás",
            "floor press" => "talajon nyomás",
            "Arnold press" => "Arnold nyomás",
            "lateral raise" => "oldalemelés",
            "front raise" => "előreemelés",
            "face pull" => "arc felé húzás",
            "lat pulldown" => "lehúzás mellhez",
            "cable row" => "csigás evezés",
            "leg press" => "lábtoló",
            "leg curl" => "lábhajlítás",
            "leg extension" => "lábnyújtás",
            "hip abduction" => "csípő távolítás",
            "hip adduction" => "csípő közelítés",
            "glute kickback" => "fenéklendítés hátra",
            "donkey kick" => "szamár rúgás",
            "monster walk" => "szörny séta",
            "band pull-apart" => "gumiszalag széthúzás",
            "banded walk" => "gumiszalagos járás",
            "scapular push-up" => "lapocka fekvőtámasz",
            "wall angel" => "fali angyal",
            "neck bridge" => "nyakhíd",
            "towel row" => "törölközős evezés",
            "push-up" => "fekvőtámasz",
            "pull-up" => "húzódzkodás",
            "squat" => "guggolás",
            "lunge" => "kitörés",
            "plank" => "deszkatartás",
            "deadlift" => "felhúzás",
            "bench press" => "fekvenyomás",
            "bicep curl" => "bicepsz hajlítás",
            "tricep dip" => "tricepsz tolódzkodás",
            "shoulder press" => "vállból nyomás",
            "jumping jack" => "terpesz-zár szökdelés",
            "burpee" => "burpee",
            "mountain climber" => "hegymászó",
            "leg raise" => "lábemelés",
            "crunch" => "hasprés",
            "sit-up" => "felülés",
            "row" => "evezés",
            "calf raise" => "vádliemelés",
            "hip thrust" => "csípőemelés",
            "glute bridge" => "fenékhíd",
            "side plank" => "oldalsó deszkatartás",
            "high knees" => "magastérdemelés",
            "butt kick" => "sarokemelés",
            "jump squat" => "ugró guggolás",
            "step-up" => "fellépés",
            "box jump" => "dobozra ugrás",
            "wall sit" => "falnál ülés",
            "superman" => "szuperhős gyakorlat",
            "bird dog" => "madár-kutya",
            "reverse lunge" => "hátralépéses kitörés",
            "sumo squat" => "szumó guggolás",
            "sprawl" => "terpeszbe ugrás",
            "pike push-up" => "csípőemeléses fekvőtámasz",
            "inchworm" => "hernyógyakorlat",
            "Russian twist" => "orosz csavarás",
            "flutter kick" => "lebegő láblendítés",
            "v-up" => "V-felülés",
            "toe touch" => "lábujjérintés",
            "hollow hold" => "üreges tartás",
            "reverse crunch" => "fordított hasprés",
            "wrist curl" => "alkar hajlítás",
            "reverse wrist curl" => "alkar feszítés",
            "forearm rotation" => "alkar forgatás",
            "triceps kickback" => "tricepsz hátralendítés",
            "cable triceps pushdown" => "csigás tricepsz letolás",
            "concentration curl" => "koncentrált bicepsz hajlítás",
            "hammer curl" => "kalapács bicepsz hajlítás",
            "preacher curl" => "padon végzett bicepsz hajlítás",
            "incline dumbbell curl" => "ferde padon bicepsz hajlítás",
            "reverse curl" => "fordított bicepsz hajlítás",
            "shrug" => "vállvonogatás",
            "upright row" => "álló evezés",
            "trap raise" => "csuklya emelés",
            "good morning" => "jó reggelt gyakorlat",
            "back extension" => "hátnyújtás",
            "GHD sit-up" => "GHD felülés",
            "reverse hyperextension" => "fordított hiperextenzió",
            "cable crunch" => "csigás hasprés",
            "side bend" => "oldalra hajlás",
            "barbell rollout" => "súlyzós hasgörgetés",
            "ab wheel rollout" => "ab kerék görgetés",
            "hanging leg raise" => "függeszkedős lábemelés",
            "toes to bar" => "lábujjak a rúdhoz",
            "knees to elbows" => "térd könyökhöz",
            "L-sit" => "L-tartás",
            "dragon flag" => "sárkányzászló",
            "windshield wiper" => "ablaktörlő",
            "plank to push-up" => "deszkából fekvőtámasz",
            "elbow plank" => "alkartámasz",
            "knee push-up" => "térdes fekvőtámasz",
            "spider crawl" => "pókjárás",
            "bear crawl" => "medvejárás",
            "crab walk" => "rákjárás",
            "duck walk" => "kacsajárás",
            "wall climb" => "falra mászás",
            "rope climb" => "kötélmászás",
            "tire flip" => "gumiabroncs forgatás",
            "sledgehammer swing" => "kalapács lendítés",
            "log press" => "rönk nyomás",
            "atlas stone lift" => "atlasz kő emelés",
            "yoke carry" => "járókeret cipelés",
            "sandbag clean" => "homokzsák felvétel",
            "sandbag carry" => "homokzsák cipelés",
            "stone over bar" => "kő átemelése rúdon",
            "man maker" => "emberépítő gyakorlat",
            "thruster" => "guggolásból nyomás",
            "devil press" => "ördögnyomás",
            "body saw" => "testsűrű csúsztatás",
            "reverse plank" => "hátsó deszkatartás",
            "ankle circles" => "bokakörzés",
            "shoulder circles" => "vállkörzés",
            "arm swings" => "karlengetés",
            "arm circles" => "karkörzés",
            "hip circles" => "csípőkörzés",
            "neck rolls" => "nyakkörzés",
            "leg swings" => "lábhinta",
            "cat cow stretch" => "macska-tehén nyújtás",
            "child's pose" => "gyermekpóz",
            "cobra stretch" => "kobra nyújtás",
            "downward dog" => "lefelé néző kutya",
            "upward dog" => "felfelé néző kutya",
            "thread the needle" => "tű befűzése",
            "world's greatest stretch" => "világ legjobb nyújtása",
            "seated forward fold" => "ülő előrehajlás",
            "butterfly stretch" => "pillangó nyújtás",
            "hamstring stretch" => "combhajlító nyújtás",
            "quad stretch" => "combfeszítő nyújtás",
            "calf stretch" => "vádli nyújtás",
            "hip flexor stretch" => "csípőhajlító nyújtás",
            "spinal twist" => "gerinccsavarás",
            "kneeling lunge stretch" => "térdelő kitörés nyújtás",
            "wall calf stretch" => "falnál végzett vádli nyújtás",
            "pigeon pose" => "galambpóz",
            "figure four stretch" => "négyes alakú nyújtás",
            "frog stretch" => "békapóz",
            "scorpion stretch" => "skorpió nyújtás",
            "lat stretch" => "hátizom nyújtás",
            "chest opener" => "mellkasnyitás",
            "shoulder stretch" => "vállnyújtás",
            "wrist stretch" => "csukló nyújtás",
            "standing forward fold" => "álló előrehajlás",
            "side lunge stretch" => "oldalsó kitörés nyújtás",
            "toe touch stretch" => "lábujjérintés nyújtás",
            "groin stretch" => "ágyéknyújtás",
            "thoracic rotation" => "háti gerinc forgatás",
            "shoulder dislocates" => "vállkörzés bottal",
            "band shoulder stretch" => "gumis vállnyújtás",
            "partner hamstring stretch" => "páros combhajlító nyújtás",
            "supine twist" => "háton fekvő csavarás",
            "lying knee hug" => "fekvő térdhúzás",
            "bridge pose" => "hídpóz",
            "wall sit with reach" => "falnál ülés karnyújtással",
            "foam rolling" => "hengeres hengerezés",
            "quad foam roll" => "comb hengerezés",
            "IT band roll" => "IT szalag hengerezés",
            "glute foam roll" => "fenék hengerezés",
            "calf foam roll" => "vádli hengerezés",
            "upper back roll" => "felső hát hengerezés",
            "boxer push-up" => "bokszoló fekvőtámasz",
            "archer push-up" => "íjász fekvőtámasz",
            "typewriter push-up" => "írógép fekvőtámasz",
            "planche lean" => "planche előredőlés",
            "planche hold" => "planche tartás",
            "tuck planche" => "behúzott planche",
            "pseudo push-up" => "ál-fekvőtámasz",
            "wall handstand" => "falnál kézállás",
            "freestanding handstand" => "szabad kézállás",
            "handstand walk" => "kézállásban járás",
            "L-sit to handstand" => "L-tartásból kézállás",
            "press to handstand" => "nyomásból kézállás",
            "tuck jump" => "behúzott térdes ugrás",
            "depth jump" => "mélybe ugrás",
            "broad jump" => "távolugrás helyből",
            "lateral jump" => "oldalirányú ugrás",
            "zig zag run" => "cikkcakk futás",
            "agility ladder drill" => "gyorsasági létra gyakorlat",
            "cone shuffle" => "bója szlalom",
            "reaction drill" => "reakciós gyakorlat",
            "mirror drill" => "tükör gyakorlat",
            "band resisted sprint" => "gumis ellenállásos sprint",
            "hill sprint" => "emelkedős sprint",
            "backpedal run" => "hátrafelé futás",
            "carioca drill" => "keresztezett futás (carioca)",
            "bounding" => "szökdelés",
            "single leg hop" => "egylábas ugrás",
            "single leg deadlift" => "egylábas felhúzás",
            "pistol squat" => "pisztoly guggolás",
            "skater squat" => "korcsolyázó guggolás",
            "Cossack squat" => "kozák guggolás",
            "shrimp squat" => "rák guggolás",
            "Sissy squat" => "sissy guggolás",
            "step down" => "lépés lefelé",
            "box negative" => "dobozról lassított ereszkedés",
            "band assisted pull-up" => "gumis segítséggel húzódzkodás",
            "negative pull-up" => "negatív húzódzkodás",
            "weighted pull-up" => "súlyos húzódzkodás",
            "chest to bar" => "mellkas a rúdhoz",
            "kipping pull-up" => "kipping húzódzkodás",
            "butterfly pull-up" => "pillangó húzódzkodás",
            "bar muscle-up" => "rúdon muscle-up",
            "ring row" => "gyűrűs evezés",
            "ring dip" => "gyűrűs tolódzkodás",
            "ring push-up" => "gyűrűs fekvőtámasz",
            "ring support hold" => "gyűrű tartás",
            "ring L-sit" => "gyűrűs L-tartás",
            "skin the cat" => "bőr a macskán (gyűrűs fordulat)",
            "wrist push-up" => "csuklón végzett fekvőtámasz",
            "fingertip push-up" => "ujjbegyes fekvőtámasz",
            "clapping pull-up" => "tapsos húzódzkodás",
            "around the world pull-up" => "körkörös húzódzkodás",
            "explosive push-up" => "robbanékony fekvőtámasz",
            "hand release push-up" => "kéz elemelős fekvőtámasz",
            "scapula pull-up" => "lapocka húzódzkodás",
            "wall walk-up" => "falon felfelé járás",
            "rope push-up" => "kötélen végzett fekvőtámasz",
            "parallette dip" => "parallette tolódzkodás",
            "towel pull-up" => "törölközős húzódzkodás",
            "rope row" => "kötélen evezés",
            "hollow rock" => "üreges hintázás",
            "superman hold" => "szuperhős tartás",
            "banana roll" => "banánforgás",
            "wall toe touch" => "falnál lábujjérintés",
            "dragon walk" => "sárkányjárás",
            "plank shoulder tap" => "deszkatartás vállérintéssel",
            "plank jack" => "deszkatartás ugrással",
            "plank reach" => "deszkatartás karnyújtással",
            "dead bug" => "halott bogár",
            "bird dog crunch" => "madár-kutya hasprés",
            "side plank dip" => "oldalsó deszka süllyesztéssel",
            "side crunch" => "oldalsó hasprés",
            "crossbody mountain climber" => "átlós hegymászó",
            "star jump" => "csillagugrás",
            "triple jump" => "hármasugrás",
            "donkey jump" => "szamárugrás",
            "kneeling jump" => "térdelésből felugrás",
            "partner toss" => "páros labdadobás",
            "med ball chest pass" => "gyógylabda mellkasi passz",
            "wall throw" => "falra dobás",
            "overhead throw" => "fej fölötti dobás",
            "underhand throw" => "alulról dobás",
            "soccer taps" => "focis lábérintés",
            "lateral hurdle hop" => "oldalsó gátugrás",
            "line hop" => "vonalugrás",
            "speed skater" => "gyorskorcsolyázó mozdulat",
            "cross jump" => "keresztezett ugrás",
            "bear hold" => "medve tartás",
            "loaded beast" => "terhelt vadállat pozíció",
            "beast reach" => "vadállat karnyújtás",
            "ape walk" => "majomjárás",
            "crab reach" => "rák karnyújtás",
            "scorpion reach" => "skorpió karnyújtás",
            "sit through" => "ülésen átfordulás",
            "kick through" => "rúgással átfordulás",
            "breakdancer" => "breaktáncos mozdulat",
            "bottom squat hold" => "guggolás alján tartás",
            "sumo squat" => "szumó guggolás",
            "frog squat" => "béka guggolás",
            "side lunge" => "oldalsó kitörés",
            "curtsy lunge" => "pózolós kitörés",
            "hover lunge" => "lebegő kitörés",
            "step up to balance" => "fellépés egyensúllyal",
            "reverse Nordic curl" => "hátrafele északi hajlítás",
            "partner Nordic curl" => "páros északi hajlítás",
            "barbell good morning" => "rúddal végzett 'jó reggelt'",
            "seated good morning" => "ülő 'jó reggelt' gyakorlat",
            "wall facing squat" => "fal felé guggolás",
            "shoulder dislocate" => "váll átvezetés",
            "barbell overhead squat" => "rúddal végzett fej fölötti guggolás",
            "sots press" => "guggolás közbeni nyomás",
            "overhead lunge" => "fej fölötti kitörés",
            "split jerk" => "szakításos kitörés",
            "power clean" => "erőfelvétel",
            "hang clean" => "lógásból felvétel",
            "snatch balance" => "szakítás egyensúllyal",
            "push press" => "nyomás lendülettel",
            "push jerk" => "rúgásos nyomás",
            "thruster" => "guggolásból nyomás",
            "wall walk to handstand" => "falon mászás kézállásba",
            "frog stand" => "békaállás",
            "pseudo planche push-up" => "ál-planche fekvőtámasz",
            "straddle press to handstand" => "terpeszes nyomás kézállásba",
            "L-sit pull-up" => "L-tartásos húzódzkodás",
            "front lever row" => "előretartásos evezés",
            "back lever hold" => "hátratartás tartás",
            "straddle back lever" => "terpeszes hátratartás",
            "pelican push-up" => "pelikán fekvőtámasz",
            "german hang" => "német lógás",
            "meat hook" => "húsakasztás gyakorlat",
            "front lever pull" => "előretartásos húzás",
            "wall assisted tuck" => "falnál segített behúzott tartás",
            "straight arm plank" => "egyenes karos deszka",
            "low push-up hold" => "alacsony fekvőtámasz tartás",
            "hand release burpee" => "kézemelős burpee",
            "burpee to pull-up" => "burpee húzódzkodással",
            "man maker" => "férfi gyilkos gyakorlat (súlyzókkal)",
            "devil press" => "ördögi nyomás",
            "dumbbell snatch" => "kézisúlyos szakítás",
            "dumbbell clean and press" => "kézisúlyos felvétel és nyomás",
            "renegade row" => "lázadó evezés",
            "dumbbell thruster" => "kézisúlyos guggolásból nyomás",
            "z-press" => "Z-nyomás ülve",
            "arnold press" => "Arnold-féle nyomás",
            "lateral raise" => "oldalemelés",
            "front raise" => "elöreemelés",
            "reverse fly" => "hátraemelés",
            "face pull" => "arc felé húzás",
            "overhead triceps extension" => "fej fölötti tricepsznyújtás",
            "skull crusher" => "koponyazúzó (tricepsz gyakorlat)",
            "kickback" => "tricepsz rúgás",
            "hammer curl" => "kalapács bicepsz hajlítás",
            "preacher curl" => "padon végzett bicepszgyakorlat",
            "concentration curl" => "koncentrált bicepszgyakorlat",
            "zottman curl" => "zottman bicepsz hajlítás",
            "incline dumbbell curl" => "lejtős padon bicepszgyakorlat",
            "drag curl" => "húzott bicepszgyakorlat",
            "reverse curl" => "fordított bicepszgyakorlat",
            "barbell curl" => "rúddal végzett bicepszgyakorlat",
            "chin-up hold" => "húzódzkodás tartás (alsó fogás)",
            "negative chin-up" => "negatív húzódzkodás",
            "weighted pull-up" => "súlyozott húzódzkodás",
            "archer push-up" => "íjász fekvőtámasz",
            "typewriter push-up" => "írógép fekvőtámasz",
            "planche lean" => "planche döntés",
            "planche push-up" => "planche fekvőtámasz",
            "tuck planche" => "behúzott planche",
            "advanced tuck planche" => "haladó behúzott planche",
            "straddle planche" => "terpeszes planche",
            "full planche" => "teljes planche",
            "wall assisted planche" => "falnál segített planche",
            "pike push-up" => "pike fekvőtámasz",
            "elevated pike push-up" => "magasított pike fekvőtámasz",
            "handstand negative" => "kézállásból ereszkedés",
            "freestanding handstand" => "szabad kézállás",
            "handstand press" => "kézállásba nyomás",
            "box L-sit" => "dobozos L-tartás",
            "floor L-sit" => "talajon L-tartás",
            "L-sit to tuck" => "L-tartásból behúzás",
            "L-sit to handstand" => "L-tartásból kézállás",
            "ring dip" => "gyűrűs tolódzkodás",
            "ring push-up" => "gyűrűs fekvőtámasz",
            "ring row" => "gyűrűs evezés",
            "ring fly" => "gyűrűs karemelés",
            "ring support hold" => "gyűrűs tartás",
            "ring turnout" => "gyűrűs kifordítás",
            "false grip hang" => "hamis fogás lógás",
            "muscle-up transition" => "muscle-up átmenet",
            "strict muscle-up" => "szabályos muscle-up",
            "kipping muscle-up" => "lendületes muscle-up",
            "bar dip" => "rúdon végzett tolódzkodás",
            "bar support hold" => "rúdon tartás",
            "front lever raise" => "előretartásba emelés",
            "ice cream maker" => "fagylaltkészítő gyakorlat (statikus húzás)",
            "tuck front lever" => "behúzott előretartás",
            "straddle front lever" => "terpeszes előretartás",
            "one arm push-up" => "egykézes fekvőtámasz",
            "one arm plank" => "egykézes deszkatartás",
            "one arm row" => "egykézes evezés",
            "one leg squat" => "egylábas guggolás",
            "shrimp squat" => "rák guggolás",
            "skater squat" => "korcsolyázó guggolás",
            "assisted pistol squat" => "segített pisztolyguggolás",
            "box pistol squat" => "dobozos pisztolyguggolás",
            "deck pistol" => "gurulós pisztolyguggolás",
            "band-assisted pistol" => "gumis pisztolyguggolás",
            "weighted pistol squat" => "súlyozott pisztolyguggolás",
            "wall sit march" => "falnál ülés meneteléssel",
            "cossack squat" => "kosszak guggolás",
            "deep lateral lunge" => "mély oldalsó kitörés",
            "banded side step" => "gumis oldalra lépés",
            "monster walk" => "szörnyjárás (gumis szalaggal)",
            "b-stance deadlift" => "B-állású felhúzás",
            "kickstand deadlift" => "támaszos felhúzás",
            "single leg RDL" => "egylábas román felhúzás",
            "toe elevated RDL" => "lábujj emeléses román felhúzás",
            "trap bar deadlift" => "trap rudas felhúzás",
            "sumo deadlift" => "szumó felhúzás",
            "deficit deadlift" => "mélyített felhúzás",
            "snatch grip deadlift" => "szakításfogásos felhúzás",
            "block pull" => "emelvényről felhúzás",
            "rack pull" => "állványról felhúzás",
            "pin squat" => "tűguggolás",
            "box squat" => "dobozos guggolás",
            "pause squat" => "megállított guggolás",
            "tempo squat" => "tempós guggolás",
            "speed squat" => "gyors guggolás",
            "band-resisted squat" => "ellenállásos guggolás",
            "chain squat" => "láncos guggolás",
            "front rack hold" => "elülső tartás rúddal",
            "overhead hold" => "fej fölötti tartás",
            "yoke walk" => "iga cipelés",
            "sandbag carry" => "homokzsák cipelés",
            "keg clean and press" => "hordó felvétel és nyomás",
            "log press" => "rönk nyomás",
            "stone load" => "kőemelés",
            "duck walk" => "kacsajárás",
            "zercher squat" => "Zercher guggolás",
            "barbell hack squat" => "rúddal végzett hack guggolás",
            "jefferson squat" => "Jefferson-féle guggolás",
            "sissy squat" => "sissy guggolás",
            "reverse hyperextension" => "fordított hiperhajlítás",
            "glute ham raise" => "fenék-comb emelés padon",
            "banded good morning" => "gumis 'jó reggelt' gyakorlat",
            "nordic hamstring curl" => "északi combhajlítás",
            "hip airplane" => "csípő repülő tartás",
            "shin box switch" => "lábváltás térdtartásban",
            "psoas march" => "psoas menetelés",
            "side plank with reach" => "oldalsó deszka karnyújtással",
            "bear plank shoulder tap" => "medve deszka vállérintéssel",
            "kickthrough" => "átfordulás (kutyás mozgásból)",
            "beast crawl" => "fenevad mászás",
            "scorpion reach" => "skorpió nyújtás",
            "bird dog crunch" => "madár-kutya hasprés",
            "dead bug hold" => "holt bogár tartás",
            "dead bug with band" => "holt bogár gumiszalaggal",
            "cable pull through" => "kábeles áthúzás",
            "landmine squat" => "landmine guggolás",
            "landmine press" => "landmine nyomás",
            "landmine row" => "landmine evezés",
            "landmine rotation" => "landmine törzsfordítás",
            "landmine clean" => "landmine felvétel",
            "body saw" => "testfűrész (deszkából előre-hátra csúszás)",
            "slide-out plank" => "csúsztatós deszka",
            "ab wheel rollout" => "haskerék kigurítás",
            "stability ball rollout" => "stabilitáslabdás kigurítás",
            "stir the pot" => "fazékkeverés (labdán)",
            "weighted sit-up" => "súlyozott felülés",
            "v-up" => "V-felülés",
            "jackknife" => "zsebkés gyakorlat",
            "toes to bar" => "lábujjak a rúdhoz",
            "knees to elbows" => "térd a könyökhöz",
            "hollow hold" => "üreges tartás",
            "hollow body rock" => "üreges test hintáztatás",
            "leg raise hold" => "lábemelés tartás",
            "dragon flag" => "sárkányzászló",
            "windshield wiper" => "ablaktörlő",
            "barbell rollout" => "rúddal végzett haskigurítás",
            "plank to push-up" => "deszkából fekvőtámaszba",
            "mountain climber twist" => "hegyifutó csavarással",
            "crossbody mountain climber" => "kereszttestű hegyifutó",
            "sit-out" => "kiülés (állatmozgás)",
            "gorilla walk" => "gorillajárás",
            "panther crawl" => "párducjárás",
            "caterpillar walk" => "hernyó mozgás",
            "inchworm push-up" => "kukac fekvőtámasz",
            "duck under" => "alábújás",
            "roll to stand" => "gurulásból felállás",
            "tripod transition" => "hárompontos átmenet",
            "floor get-up" => "talajról felállás",
            "kick sit" => "rúgásos ülés",
            "bridge reach" => "híd karnyújtással",
            "high crab reach" => "magas rák nyújtással",
            "low bridge rotation" => "alacsony híd forgással",
            "scapular push-up" => "lapocka fekvőtámasz",
            "scapular pull-up" => "lapocka húzódzkodás",
            "wall scapular slide" => "falnál végzett lapockacsúsztatás",
            "wall angel" => "falangyal",
            "band pull-apart" => "gumiszalag széttépés",
            "face-down shoulder external rotation" => "hasalásban váll kiforgatás",
            "YTWL raises" => "YTWL vállgyakorlatok",
            "band dislocates" => "gumis váll átvezetés",
            "shoulder CARs" => "váll körkörös kontrollált mozgás",
            "hip CARs" => "csípő körkörös kontrollált mozgás",
            "spinal wave" => "gerinchullám",
            "segmental cat cow" => "szegmentált macska-tehén",
            "thread the needle" => "tűbefűzés",
            "90/90 switch" => "90/90 lábváltás",
            "hip lift with reach" => "csípőemelés karnyújtással",
            "hamstring slider curl" => "combhajlító csúsztatás",
            "sliding lunge" => "csúszó kitörés",
            "slider pike" => "csúszó pike gyakorlat",
            "slider mountain climber" => "csúszó hegyifutó",
            "wall assisted backbend" => "falnál segített hátrahajlás",
            "shoulder bridge" => "vállhíd",
            "wheel pose" => "kerékpóz",
            "table bridge" => "asztal híd",
            "neck bridge" => "nyakhíd",
            "wrist push-up" => "csukló fekvőtámasz",
            "wrist extension stretch" => "csukló feszítéses nyújtás",
            "elbow circle" => "könyökkörzés",
            "ankle CARs" => "boka körkörös kontrollált mozgás",
            "toe raise" => "lábujj emelés",
            "heel walk" => "sarokjárás",
            "toe walk" => "lábujjhegyen járás",
            "short foot drill" => "rövidláb gyakorlat",
            "tibialis raise" => "sípcsonti emelés",
            "band resisted dorsiflexion" => "gumis ellenállásos bokahajlítás",
            "banded ankle inversion" => "gumis boka befelé forgatás",
            "weighted calf raise" => "súlyozott vádlifelhúzás",
            "seated calf raise" => "ülő vádlifelhúzás",
            "donkey calf raise" => "szamár vádlifelhúzás",
            "barbell calf raise" => "rúddal vádlizás",
            "jump rope double unders" => "duplázott ugrókötél",
            "lateral pogo hop" => "oldalsó pattogó ugrás",
            "skater hop" => "korcsolyás ugrás",
            "broad jump" => "távolugrás",
            "vertical jump" => "függőleges ugrás",
            "depth jump" => "mélybeugrás",
            "rebound jump" => "visszaugrás",
            "single leg bound" => "egylábas szökdelés",
            "tuck jump" => "térdfelhúzásos ugrás",
            "box jump over" => "átugrás dobozon",
            "box depth drop" => "leugrás dobozról",

            "box rebound jump" => "visszaugrás dobozról",

            "frog jump" => "békaugrás",

            "split squat jump" => "váltott lábú guggoló ugrás",

            "lateral bound" => "oldalsó szökdelés",

            "power skip" => "erőteljes ugró szökdelés",

            "single leg box jump" => "egylábas dobozra ugrás",

            "zigzag hop" => "cikkcakk ugrás",

            "jumping lunge" => "ugráló kitörés",

            "lunge to knee drive" => "kitörés térdemeléssel",

            "reverse lunge to hop" => "hátralépéses kitörés ugrással",

            "bounding sprint" => "szökdelő sprint",

            "resisted sprint" => "ellenállásos sprint",

            "sled push" => "szán tolás",

            "sled pull" => "szán húzás",

            "hill sprint" => "emelkedőn sprintelés",

            "stair sprint" => "lépcső sprint",

            "backpedal drill" => "hátrafelé futás gyakorlat",

            "lateral shuffle" => "oldalsó lépegetés",

            "karaoke drill" => "keresztező futás",

            "agility ladder quick feet" => "gyors lábmunka létrán",

            "agility ladder in and out" => "létra be-ki gyakorlat",

            "cone drill" => "bója gyakorlat",

            "zigzag sprint" => "cikkcakk sprint",

            "T-drill" => "T-alakú futás gyakorlat",

            "pro agility drill" => "profi ügyességi gyakorlat",

            "mirror drill" => "tükör gyakorlat",

            "shuttle run" => "oda-vissza futás",

            "suicides" => "fokozatos futás (suicidok)",

            "reaction sprint" => "reakciós sprint",

            "ball drop sprint" => "labdaejtéses sprint",

            "turn and go" => "fordulás és indulás",

            "3-point start" => "hárompontos rajt",

            "falling start" => "dőléses rajt",

            "resisted lateral walk" => "ellenállásos oldaljárás",

            "mini band side step" => "mini szalagos oldalra lépés",

            "banded squat walk" => "gumis guggolójárás",

            "wall drill" => "fali futás gyakorlat",

            "ankling drill" => "bokamunka gyakorlat",

            "A-skip" => "A-szökdelés",

            "B-skip" => "B-szökdelés",

            "high knee run" => "magastérdemeléses futás",

            "butt kick run" => "sarokemeléses futás",

            "straight leg run" => "nyújtott lábú futás",

            "carioca" => "keresztező lépés (carioca)",
            "lat pulldown" => "lehúzás széles fogással",

            "seated row" => "ülő evezés",

            "cable row" => "kábeles evezés",

            "chest press machine" => "mellgép",

            "pec deck" => "tárogatógép",

            "shoulder press machine" => "vállnyomó gép",

            "cable lateral raise" => "kábeles oldalemelés",

            "leg press" => "lábnyomó gép",

            "leg extension" => "lábnyújtó gép",

            "leg curl" => "lábhajlító gép",

            "hack squat machine" => "hack guggoló gép",

            "smith machine squat" => "smith gépes guggolás",

            "smith machine bench press" => "smith gépes fekvenyomás",

            "cable chest fly" => "kábeles mell tárogatás",

            "triceps pushdown" => "tricepsz letolás",

            "bicep cable curl" => "bicepsz kábeles hajlítás",

            "cable crunch" => "kábeles hasprés",

            "reverse pec deck" => "hátsó váll pec deck",

            "pull-through" => "áthúzás csigán",

            "assisted pull-up machine" => "segített húzódzkodó gép",

            "assisted dip machine" => "segített tolódzkodó gép",

            "glute kickback machine" => "farizom toló gép",

            "hip abduction machine" => "csípő távolító gép",

            "hip adduction machine" => "csípő közelítő gép",

            "calf raise machine" => "vádli gép",

            "seated calf machine" => "ülő vádligép",

            "standing calf machine" => "álló vádligép",

            "abduction cable" => "kábeles csípő távolítás",

            "adduction cable" => "kábeles csípő közelítés",

            "preacher curl machine" => "bicepsz pados hajlítás gépen",

            "triceps extension machine" => "tricepsz nyújtás gépen",

            "cable face pull" => "kábeles arc felhúzás",

            "incline chest press machine" => "ferde pados mellgép",

            "decline press machine" => "negatív pados mellgép",

            "rear delt machine" => "hátsó delta gép",

            "rowing machine" => "evezőgép",

            "elliptical trainer" => "elliptikus tréner",

            "treadmill run" => "futás futópadon",

            "stair climber" => "lépcsőzőgép",

            "spin bike" => "terepi kerékpár (teremben)",

            "cable lateral lunge" => "kábeles oldalirányú kitörés",

            "cable woodchopper" => "kábeles favágó",

            "cable twist" => "kábeles törzsfordítás",

            "cable pull-in" => "kábeles behúzás",

            "low to high cable fly" => "alulról felfelé kábeles tárogatás",

            "high to low cable fly" => "felülről lefelé kábeles tárogatás",

            "machine crunch" => "hasprés gépen",

            
            "machine shoulder shrug" => "vállvonogatás gépen",

            "cable front raise" => "kábeles előreemelés",

            "cable upright row" => "kábeles állig húzás",

            "cable rear delt fly" => "kábeles hátsó váll tárogatás",

            "cable hip thrust" => "kábeles csípőemelés",

            "cable glute bridge" => "kábeles farizomhíd",

            "ab roller machine" => "haskerék gépen",

            "vertical leg press" => "függőleges lábnyomó gép",

            "lever row machine" => "karos evezőgép",

            "lever chest press" => "karos mellnyomás",

            "lever shoulder press" => "karos vállnyomás",

            "lever incline press" => "karos ferde mellnyomás",

            "lever decline press" => "karos negatív mellnyomás",

            "standing cable chest press" => "álló helyzetű kábeles mellnyomás",

            "cable kneeling crunch" => "térdelő kábeles hasprés",

            "cable kickback" => "kábeles lábtolás hátra",

            "cable squat" => "kábeles guggolás",

            "machine lateral raise" => "oldalemelés gépen",

            "machine front raise" => "előreemelés gépen",

            "machine reverse fly" => "hátsó vállgép",

            "machine ab rotation" => "törzsfordító gép",

            "machine torso twist" => "törzs csavarás gépen",

            "glute bridge machine" => "farizom hídgép",

            "hip thrust machine" => "csípőemelő gép",

            "lying leg curl machine" => "hanyatt fekvő lábhajlító gép",

            "standing leg curl machine" => "álló lábhajlító gép",

            "inner thigh machine" => "belső comb gép",

            "outer thigh machine" => "külső comb gép",

            "butterfly machine" => "pillangó gép (melltárogatás)",

            "reverse butterfly machine" => "fordított pillangó gép (hátsó váll)",

            "iso-lateral row" => "egykezes karos evezés",

            "iso-lateral press" => "egykezes karos nyomás",

            "iso-lateral shoulder press" => "egykezes karos vállnyomás",

            "smith machine split squat" => "smith gépes kitörés",

            "smith machine hip thrust" => "smith gépes csípőemelés",

            "smith machine overhead press" => "smith gépes fej fölé nyomás",

            "smith machine upright row" => "smith gépes állig húzás",

            "smith machine calf raise" => "smith gépes vádli",

            "smith machine good morning" => "smith gépes törzsdöntés",

            "dual cable cross" => "kétkaros kábeles tárogatás",

            "cable concentration curl" => "kábeles koncentrált bicepsz",

            "cable overhead triceps extension" => "kábeles tricepsznyújtás fej fölött",

            "cable rope hammer curl" => "köteles kábeles kalapács bicepsz",

            "rope face pull" => "köteles arc felhúzás",

            "rope triceps pushdown" => "köteles tricepsz letolás",

            
            "incline bench press" => "ferde pados fekvenyomás",

            "decline bench press" => "negatív pados fekvenyomás",

            "close grip bench press" => "szűkfogású fekvenyomás",

            "barbell bench press" => "súlyzós fekvenyomás",

            "barbell squat" => "rúddal guggolás",

            "front squat" => "elülső guggolás",

            "overhead squat" => "fej fölötti guggolás",

            "sumo deadlift" => "szumó felhúzás",

            "Romanian deadlift" => "román felhúzás",

            "conventional deadlift" => "klasszikus felhúzás",

            "trap bar deadlift" => "trap bar felhúzás",

            "barbell row" => "súlyzós evezés",

            "T-bar row" => "T-rudas evezés",

            "pendlay row" => "pendlay evezés",

            "landmine row" => "landmine evezés",

            "landmine press" => "landmine nyomás",

            "landmine squat" => "landmine guggolás",

            "landmine twist" => "landmine törzsfordítás",

            "barbell curl" => "rúddal bicepsz hajlítás",

            "EZ-bar curl" => "EZ-rudas bicepsz hajlítás",

            "preacher curl" => "Scott-pados bicepsz hajlítás",

            "hammer curl" => "kalapács bicepsz hajlítás",

            "concentration curl" => "koncentrált bicepsz hajlítás",

            "incline dumbbell curl" => "ferde padon bicepsz hajlítás",

            "Zottman curl" => "Zottman bicepsz",

            "skullcrusher" => "francia tricepsznyújtás",

            "overhead triceps extension" => "tricepsznyújtás fej fölött",

            "triceps kickback" => "tricepsz tolás hátra",

            "French press" => "francia nyomás",

            "dumbbell bench press" => "kézisúlyzós fekvenyomás",

            "dumbbell fly" => "kézisúlyzós tárogatás",

            "dumbbell incline press" => "ferde pados kézisúlyzós nyomás",

            "dumbbell shoulder press" => "kézisúlyzós vállnyomás",

            "arnold press" => "Arnold nyomás",

            "dumbbell lateral raise" => "kézisúlyzós oldalemelés",

            "dumbbell front raise" => "kézisúlyzós előreemelés",

            "dumbbell reverse fly" => "hátsó váll kézisúlyzóval",

            "bent-over lateral raise" => "döntött törzsű oldalemelés",

            "one-arm row" => "egykezes evezés",

            "dumbbell row" => "kézisúlyzós evezés",

            "dumbbell pullover" => "kézisúlyzós áthúzás",

            "dumbbell deadlift" => "kézisúlyzós felhúzás",

            "dumbbell lunge" => "kézisúlyzós kitörés",

            "walking lunge" => "sétáló kitörés",

            "bulgarian split squat" => "bolgár kitörés",

            "step-up" => "fellépés",

            "box squat" => "dobozra guggolás",

            "glute bridge" => "farizomhíd",

            "hip thrust" => "csípőemelés",

            "good morning" => "törzsdöntés",

            "calf raise" => "vádliemelés",

            "seated calf raise" => "ülő vádliemelés",

            "standing calf raise" => "álló vádliemelés",

            "leg press calf raise" => "vádliemelés lábtoló gépen",

            "barbell rollout" => "rúddal haskerék",

            "weighted sit-up" => "súlyos felülés",

            "weighted plank" => "súlyos plank",

            "Russian twist" => "orosz törzsfordítás",

            "leg raise" => "lábemelés",

            "hanging leg raise" => "függeszkedéses lábemelés",

            "toes to bar" => "lábujj a rúdhoz",

            "knee raise" => "térdemelés",

            
            "cable chest press" => "kábeles mellnyomás",

            "cable incline press" => "kábeles ferde mellnyomás",

            "cable decline press" => "kábeles negatív mellnyomás",

            "cable crossover low to high" => "kábeles keresztbehúzás alulról felfelé",

            "cable crossover high to low" => "kábeles keresztbehúzás felülről lefelé",

            "machine preacher curl" => "bicepsz hajlítás Scott-gépen",

            "machine triceps press" => "tricepsz nyomás gépen",

            "machine lateral raise" => "oldalemelés gépen",

            "lever row" => "karos evezés",

            "lever incline press" => "karos ferde mellnyomás",

            "lever decline press" => "karos negatív mellnyomás",

            "lever shoulder press" => "karos vállnyomás",

            "lever chest press" => "karos mellnyomás",

            "lever leg press" => "karos lábnyomás",

            "lever leg extension" => "karos lábnyújtás",

            "lever leg curl" => "karos lábhajlítás",

            "standing leg curl" => "álló lábhajlítás",

            "lying leg curl" => "hanyattfekvő lábhajlítás",

            "leg extension machine" => "lábnyújtás gépen",

            "ab crunch machine" => "hasprés gépen",

            "cable woodchopper high to low" => "kábeles favágó felülről lefelé",

            "cable woodchopper low to high" => "kábeles favágó alulról felfelé",

            "reverse lunge" => "hátralépéses kitörés",

            "side lunge" => "oldalsó kitörés",

            "curtsy lunge" => "keresztlépéses kitörés",

            "barbell hip thrust" => "rúddal csípőemelés",

            "barbell glute bridge" => "rúddal farizomhíd",

            "smith machine lunge" => "smith gépes kitörés",

            "smith machine calf raise" => "smith gépes vádli",

            "smith machine good morning" => "smith gépes törzsdöntés",

            "smith machine split squat" => "smith gépes bolgár kitörés",

            "reverse pec deck" => "hátsó váll pec deck",

            "cable kneeling row" => "térdelő kábeles evezés",

            "cable squat to row" => "kábeles guggolásból evezés",

            "weighted pull-up" => "súlyos húzódzkodás",

            "weighted dip" => "súlyos tolódzkodás",

            "assisted chin-up" => "segített húzódzkodás (tenyér befelé)",

            "assisted pull-up" => "segített húzódzkodás (tenyér kifelé)",

            "assisted dip" => "segített tolódzkodás",

            "iso-lateral row machine" => "egykezes karos evezőgép",

            "iso-lateral chest press" => "egykezes karos mellnyomás",

            "iso-lateral shoulder press" => "egykezes karos vállnyomás",

            "rowing ergometer" => "evező ergométer",

            "elliptical machine" => "elliptikus tréner",

            "stepmill" => "lépcsőzőgép",
            "spin bike" => "termi szobabicikli",
            "treadmill sprint" => "gyors futás futópadon",
            "air bike sprints" => "légellenállásos kerékpár sprint",
            "sled push" => "szán tolás",
            "sled pull" => "szán húzás",
            "battle rope slams" => "kötélcsapás",
            "medicine ball slam" => "gyógylabda lecsapás",
            "medicine ball chest pass" => "gyógylabdás mellből dobás",
            "wall ball shots" => "gyógylabdás fali dobás"
        ];
    
        function translate($text, $dictionary) {
            foreach ($dictionary as $english => $hungarian) {
                $text = str_replace($english, $hungarian, $text);
            }
            return $text;
        }
        
        $translated_workout_plan = translate($clean_workout_plan, $dictionary);

        // Edzésterv mentése
        $stmt = $conn->prepare("INSERT INTO user_workout_plan (user_id, plan) VALUES (?, ?)");
        $stmt->bind_param("is", $userID, $translated_workout_plan);

        if (!$stmt->execute()) {
            die("Hiba: Nem sikerült elmenteni az edzéstervet.");
        }

        $stmt->close();
        $conn->close();

        header("Location: profil.php");

        exit();
    }
?>

<form id="aiForm">
    <input type="hidden" id="userData" value='<?php echo $user_data; ?>'>
</form>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Regisztráció</title>
</head>
<body>

    <div id="loader">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span>Edzésterv generálása</span>
    </div>

    <div class="container mt-5" id="multiStepFormDiv">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" id="multiStepForm">
            <div class="container">
                <div class="row">

                    <div class="step active">
                        <div id="keret">
                            <h2>Regisztráció</h2>
                            
                            <label for="username">Felhasználónév</label>
                            <input class="form-control" type="text" id="username" name="username" minlength="5"  maxlength="20" required>
                            <p class="error" id="usernameError"></p>

                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <p class="error" id="emailError"></p>

                            <label for="password">Jelszó</label>
                            <div class="password-container">
                                <input class="form-control" type="password" id="password" name="password" minlength="8"  maxlength="15" required>
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox" checked="checked">
                                    <svg id="eyeOpen" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>
                            <p class="error" id="passwordError"></p>

                            <label for="repeat-password">Jelszó megerősítése</label>
                            <div class="password-container">
                                <input class="form-control" type="password" name="repeatpassword" id="repeatpassword"  minlength="8"  maxlength="15" required>
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox2" checked="checked">
                                    <svg id="eyeOpen2" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed2" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>
                            <p class="error" id="repeatPasswordError"></p>

                            <button type="button" name="next1" onclick="nextStep1()" class="nextgomb">Következő</button>
                            <p>Van már fiókod? <a href="login.php">Jelentkezz be</a></p>
                        </div>  
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <label for="sex">Nem</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="">Válassz...</option>
                                <option value="man">Férfi</option>
                                <option value="woman">Nő</option>
                                <option value="gender not given">Nem kívánom megválaszolni</option>
                            </select>
                            <p class="error" id="sexError"></p>

                            <label for="age">Kor:</label>
                            <input class="form-control" min="14" max="100" type="number" id="age" name="age" required>
                            <p class="error" id="ageError"></p>

                            <label for="weight">Testsúly:</label>
                            <input class="form-control" min="40" max="200" type="number" id="weight" name="weight" step="any"  required>
                            <p class="error" id="weightError"></p>

                            <label for="height">Magasság:</label>
                            <input class="form-control" min="120" max="250" type="number" id="height" name="height" step="any"  required>
                            <p class="error" id="heightError"></p>

                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep2()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <div class="step">
                        <div id="keret">
                            <label for="goal">Milyen célokat szeretnél elérni?</label>
                            <select class="form-control" id="goal" name="goal" required>
                                <option value="">Válassz...</option>
                                <option value="lose weight">Fogyás</option>
                                <option value="gain muscle">Izomnövelés</option>
                                <option value="lose weight and gain muscle">Fogyás és izomtömegnövelés</option>
                                <option value="stay in shape">Formában tartás</option>
                                <option value="start an athletic career">Sportólói karrier elkezdése</option>
                            </select>
                            <p class="error" id="goalError"></p>

                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep3()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <div class="step">
                        <div id="keret">
                            <h2>Jelenlegi testalkat</h2>
                            <div class="d-flex">
                                <label>
                                    <input class="hidden testalkatin" type="radio" id="bodytype-ecto" name="bodytype" value="Ectomorph" required>
                                    <img class="testalkat" id="ectomorph-img" src="" alt="">
                                </label>
                                <label>
                                    <input class="hidden testalkatin" type="radio" id="bodytype-meso" name="bodytype" value="Mesomorph">      
                                    <img class="testalkat" id="mesomorph-img" src="" alt="">
                   
                                </label>
                                <label>
                                    <input class="hidden testalkatin" type="radio" id="bodytype-endo" name="bodytype" value="Endomorph">                        
                                    <img class="testalkat" id="endomorph-img" src="" alt="">
                                </label>
                            </div>
                            <p class="error" id="bodytypeError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep4()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Jelenlegi testzsírszázalék</h2>
                            <img id="bodyfat-image" src="" alt="Testzsíszázalék">
                            <p id="bodyfat-text">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range" name="bodyfat-range" required>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep5()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">                                                                                                                      
                        <div id="keret">
                            <h2>Cél testzsírszázalék</h2>
                            <img id="bodyfat-image2" src="" alt="Testzsíszázalék" >
                            <p id="bodyfat-text2">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range2" name="bodyfat-range2" required>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep6()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Hányszor edzel egy héten?</h2>    
                            <div class="d-flex flex-column">
                                <label class="workout-card" id="workout-frequency1-label">1-2x hetente 
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency1" value="1-2" required>
                                </label>                                                     
                                <label class="workout-card" id="workout-frequency2-label">3x hetente
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency2" value="3">
                                </label>  
                                <label class="workout-card" id="workout-frequency3-label">Több mint 4x hetente 
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency3" value="more than 4" >
                                </label> 
                                <label class="workout-card" id="workout-frequency4-label">Nem edzek
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency4" value="does not work out">
                                </label>  
                            </div>   
                            <p class="error" id="workoutError"></p>
                            <button type="button"class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep7()" class="nextgomb">Következő</button>
                        </div>  
                    </div>

                    <div class="step">
                        <div id="keret">
                            <h2>Hány alkalommal szeretnél edzeni?</h2>                                             
                            <div class="d-flex flex-column">
                                <label class="workout-card" id="wanted-workout-frequency1-label">1x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency1" value="1" required>
                                </label>                                                     
                                <label class="workout-card" id="wanted-workout-frequency2-label">2x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency2" value="2">
                                </label>  
                                <label class="workout-card" id="wanted-workout-frequency3-label">3x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency3" value="3">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency4-label">4x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency4" value="4">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency5-label">5x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency5" value="5">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency6-label">6x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency6" value="6">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency7-label">7x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency7" value="7">
                                </label> 
                            </div>  
                            <p class="error" id="wantedWorkoutError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep8()" class="nextgomb">Következő</button>
                        </div>  
                    </div> 
                
                    <div class="step">
                        <div id="keret">
                            <h2>Hány percig szeretnél edzeni?</h2>                                             
                            <div class="d-flex flex-column">
                                <label class="workout-card" id="w-time1-label">30 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time1" value="30" required>
                                </label>                                                       
                                <label class="workout-card" id="w-time2-label">45 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time2" value="45">
                                </label>     
                                <label class="workout-card" id="w-time3-label">60 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time3" value="60">
                                </label>     
                                <label class="workout-card" id="w-time4-label">75 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time4" value="75">
                                </label>     
                                <label class="workout-card" id="w-time5-label">90 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time5" value="90">
                                </label>     
                                <label class="workout-card" id="w-time6-label">105 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time6" value="105">
                                </label>     
                                <label class="workout-card" id="w-time7-label">120 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time7" value="120">
                                </label>  
                            </div>   
                            <p class="error" id="wantedTimeError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep9()" class="nextgomb">Következő</button>
                        </div>
                    </div>  

                    <div class="step">
                        <div id="keret">
                            <h2>Hol edzel?</h2>
                            <label class="workout-card" id="place1-label">Konditerem
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace1" value="GYM" required>
                            </label>
                            <label class="workout-card" id="place2-label">Otthon
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace2" value="Home">
                            </label>
                            <label class="workout-card" id="place3-label">Hibrid
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace3" value="both in GYM and home">
                            </label>
                            <p class="error" id="placeError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep10()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Felszeretlség</h2>
                            <label class="workout-card" id="equipment1-label">Maximális felszereltség
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment1" value="max">
                            </label>
                            <label class="workout-card" id="equipment2-label">Korlátozott felszereltség
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment2" value="limited">
                            </label>
                            <label class="workout-card" id="equipment3-label">Saját testsúly
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment3" value="bodyweight">
                            </label>
                            <p class="error" id="felszereltsegError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep11()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                            <h2 class="text-center">Fókuszált izomcsoport</h2>
                            <!--<div class="d-flex flex-column">
                                <div class="row">
                                    <div class="col-6"> 
                                        <label id="focusmuscle1-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle1" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="chest">
                                            <img class="w-50" src="img/fokusz-mell.png" alt="Férfi mell">
                                        </label>
                                        <label id="focusmuscle2-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle2" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="back">
                                            <img class="w-50" src="img/fokusz-hat.png" alt="Férfi hát">
                                        </label>
                                        <label id="focusmuscle3-label"  class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle3" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="abs">
                                            <img class="w-50" src="img/fokusz-has.png" alt="Férfi has">

                                        </label>
                                        <label id="focusmuscle4-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle4" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="bicep">
                                            <img class="w-50" src="img/fokusz-bicepsz.png" alt="Férfi bicepsz">
                                        </label>
                                    </div>
                                    <div class="col-6"> 
                                        <label id="focusmuscle5-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle5" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="tricep">
                                            <img class="w-50" src="img/fokusz.tricepsz.png" alt="Férfi tricepsz">
                                        </label>
                                        <label id="focusmuscle6-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle6" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="shoulder">
                                            <img class="w-50" src="img/fokusz-vall.png" alt="Férfi váll">
                                        </label>
                                        <label id="focusmuscle7-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle7" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="quads">
                                            <img class="w-50" src="img/fokusz-lab.png" alt="Férfi Láb">
                                        </label>
                                        <label id="focusmuscle8-label" class="d-flex justify-content-center p-2 m-1 fokuszaltizomcsoport">
                                            <input id="focusmuscle8" class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="calves">
                                            <img class="w-50" src="img/fokusz-vadli.png" alt="Férfi vádli">
                                        </label>
                                    </div>
                                </div>
                            </div>-->
                            <?php
                                include("bodymap_male2.html")
                            ?>
                        <div id="keret">
                            <p class="error" id="fokuszError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep12()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Érzékeny testrész</h2>
                            <div class="d-flex flex-column">
                                <div class="row">
                                    <div class="col-6">
                                        <label id="serult1-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <input id="serult1" class="hidden" type="checkbox" name="injured[]" value="shoulder">
                                            <img class="st_kep" src="img/vall-fajdalom.jpg" alt="Váll">
                                        </label>
                                        <label id="serult2-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <img class="st_kep" src="img/konyok-fajdalom.jpg" alt="Könyök">
                                            <input id="serult2" class="hidden" type="checkbox" name="injured[]" value="elbow">
                                        </label>
                                        <label id="serult3-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <img class="st_kep" src="img/csuklo-fajdalom.jpg" alt="Csukló">
                                            <input id="serult3" class="hidden" type="checkbox" name="injured[]" value="wrist">
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label id="serult4-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <img class="st_kep" src="img/alsohati-fajdalom.jpg" alt="Alsóhát">
                                            <input id="serult4" class="hidden" type="checkbox" name="injured[]" value="lower back">
                                        </label>
                                        <label id="serult5-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <img class="st_kep" src="img/terd-fajdalom.jpg" alt="Térd">
                                            <input id="serult5" class="hidden" type="checkbox" name="injured[]" value="knee">
                                        </label>
                                        <label id="serult6-label" class="serulttest m-1 d-flex justify-content-center align-items-center">
                                            <img class="st_kep" src="img/boka-fajdalom.jpg" alt="Boka">
                                            <input id="serult6" class="hidden" type="checkbox" name="injured[]" value="ankle">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p class="error" id="serultError"></p>
                            <button type="button" class="backgomb">Vissza</button>
                            <button type="submit" name="register" class="nextgomb" id="registervege">Regisztrálás</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="js/nextStep.js"></script>
    <script src="js/showPass.js"></script>
    <!--<script src="js/bodymap_male.js"></script>-->
</body>
</html>