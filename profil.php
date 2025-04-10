<?php
    
    session_start();

    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }
    
    $email = $_SESSION["email"];

    include("database.php");


    $stmt = $conn->prepare("
    SELECT *
    FROM user_information 
    WHERE user_id = (SELECT id FROM users WHERE email = ?)
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $testsuly = $row['testsuly'];
        $kivant_edzes_hossza = $row['kivant_edzes_hossza'];
        $magassag = $row["magassag"];
        $kor = $row["kor"];
        $nem = $row["nem"];
        $bodyGoal = $row["cel"];
        $aktivitasSzint = $row["kivant_edzes_per_het"];
    
        echo "<script>
                const testsuly = $testsuly;
                const edzesHossz = $kivant_edzes_hossza;
                const magassag = $magassag;
                const kor = $kor;
                const nem = 'Férfi';
                const cel = 'Fogyás'; 
                const activity = $aktivitasSzint;
            </script>";
    } 
    
    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Edzésterv</title>
    <link rel="icon" href="img/strong.png"></link:icon>
</head>
<body>

    <header>
        <?php
            include("header.html")
        ?>
    </header>

  <main>
    
    <h1 class="ms-5 mb-5">Üdvözlünk <?php echo "" . htmlspecialchars($_SESSION["username"]) ?>!</h1>
    <p class="text-center fst-italic" id="napiMoti">""</p>

    <section id="calorie">

        <div class="calorie-bg w-50 mx-auto rounded-2">

        <h2 class="pt-3 ps-3">Kalória</h2>

        <div class="d-flex justify-content-center ps-3 pe-3 pb-5">
            <div class="progress-container">
            <div class="progress-circle d-flex align-items-center justify-content-center">
                <div class="progress-calorie d-flex align-items-center justify-content-center">
                    <span id="calorie-text" class="progress-text position-absolute fs-1"></span>
                </div>
            </div>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center">
            <input value="0" class="form-control m-1" type="number" id="calorieInput" style="width: 30%;">
            <button class="btn m-1" onclick="addCalories()" style="background-color: var(--h); color: white;">Hozzáadás</button>
        </div>

        </div>
    </section>

    <section id="steps-and-water">

        <div class="container-fluid w-50 mt-4 p-0">
            <div class="d-flex justify-content-between">
            <div class="steps p-3 rounded-2">
                <h2>Lépés</h2>
                <div class="d-flex">
                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">

                    <svg height="30px" width="50px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">

                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                    <g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M264.144,416.889L14.642,205.12L0,222.38l249.532,211.798l0.034,0.03 c28.365,23.868,64.366,37.003,101.443,37.01h159.922v-22.638H351.01C319.292,448.581,288.402,437.322,264.144,416.889z"/> <path class="st0" d="M203.394,336.186l56.013,47.136c-2.07-10.412-6.623-21.543-15.617-31.812 c-6.968-7.966-21.928-24.401-39.924-44.533C203.397,316.698,203.21,326.524,203.394,336.186z"/> <path class="st0" d="M141.098,205.698c-9.717-8.664-18.354-16.682-25.496-23.824c6.923,10.704,13.333,20.425,22.882,32.494 C139.323,211.511,140.198,208.624,141.098,205.698z"/> <path class="st0" d="M194.91,251.657c-14.556-12.107-28.463-23.816-41.054-34.745c-0.893,4.133-1.785,8.371-2.64,12.729 c9.852,11.312,22.541,24.874,39.826,42.291C192.187,265.361,193.466,258.587,194.91,251.657z"/> <path class="st0" d="M330.506,424.022c-0.372-18.197-4.4-63.248-33.957-88.205c-27.911-23.568-59.254-49.094-88.812-73.532 c-0.912,7.576-1.751,15.587-2.46,23.838c1.938,1.92,3.889,3.841,5.929,5.836c40.044,39.253,71.222,70.09,74.808,113.228 C299.34,414.654,314.525,421.052,330.506,424.022z"/> <path class="st0" d="M143.198,285.524l41.136,34.617c0.946-9.032,2.205-19.405,3.886-30.746 c-12.943-14.635-26.625-30.327-39.594-45.689C146.277,257.298,144.327,271.497,143.198,285.524z"/> <path class="st0" d="M134.872,227.196c-20.23-24.656-37.018-46.956-43.656-60.473l5.58-6.683c-0.011-0.008-0.022-0.023-0.022-0.023 l6.676-8.266c0,0,17.463,16.742,42.478,39.05c4.013-11.837,8.547-23.936,13.682-35.975l9.5,3.586c0,0-5.555,17.357-11.623,42.605 c12.654,11.087,26.628,23.028,40.951,34.7c2.686-11.394,5.788-23.043,9.392-34.707l9.35,2.483c0,0-3.616,16.922-7.156,41.533 c15.355,12.174,30.777,23.681,45.052,33.132c61.016,40.431,102.772,82.721,107.136,147.785c20.744,0,66.91,0,109.11,0 c56.584,0,48.096-56.58,11.315-65.064c-24.809-5.731-56.685-18.895-56.685-18.895c-12.576-4.193-22.867-13.39-28.44-25.421 c0,0-1.373-2.902-3.679-7.824l-46.202,13.975c-5.049,1.522-10.378-1.335-11.904-6.376c-1.527-5.048,1.327-10.382,6.375-11.904 l43.526-13.165c-3.744-7.966-8.087-17.237-12.662-27.018l-43.172,13.058c-5.04,1.523-10.378-1.327-11.904-6.375 c-1.526-5.049,1.331-10.374,6.376-11.904l40.531-12.257c-4.313-9.256-8.607-18.475-12.575-27.041l-40.262,12.174 c-5.044,1.53-10.377-1.327-11.904-6.376c-1.522-5.04,1.328-10.373,6.372-11.896l37.715-11.409 c-5.404-11.77-9.335-20.485-10.374-23.186c-4.546-11.806-14.511-44.533-37.254-26.328 c-37.389,29.922-105.596,21.138-123.204-11.574c-13.202-24.52-5.66-50.924,0-71.672c4.519-16.585-18.869-42.441-35.844-19.81 c-12.002,16-113.171,135.806-113.171,135.806l100.457,84.537C127.228,257.77,130.544,243.151,134.872,227.196z"/> </g> </g>

                    </svg>
                    
                    <p id="stepsCount">0</p>
                </div>
                <p id="stepsGoal">Cél: 10000</p>
                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div id="stepbarbar" class="progress-bar"></div>
                </div>
                <input value="0" class="form-control m-2" type="number" id="stepsInput" style="width: 45%;">
                <button class="btn m-2" onclick="lepesHozzaAd()" style="background-color: var(--h); color: white;">Hozzáadás</button>
            </div>
            <div class="water p-3 d-flex rounded-2 justify-content-between">
                <div class="d-flex flex-column">
                    <h2>Víz</h2>
                    <h4 id="waterGoal">Cél: </h4>
                    <div class="d-flex flex-row align-items-end m-2">
                        <input value="0"  class="form-control m-1" type="number" id="vizinput">
                        <label>ml</label>
                    </div>
                    <button class="btn m-2" onclick="vizHozzaAd()" style="background-color: var(--h); color: white;">Hozzáadás</button>
                </div>
                <div>
                <div id="waterbar" class="progress d-flex flex-column-reverse me-5" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div id="waterbarbar" class="progress-bar"></div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section id="workout-plan">
    <div class="container-fluid w-50 mt-4 p-0">
        <div class="w-plan-bg  p-3 rounded-2">
        <div>
            <h2>Edzés</h2>
        </div>
        <div class="d-flex justify-content-center" onclick="window.location.href='http://localhost/mindfit/MindFit/edzesterv.php'" style="cursor: pointer;">
            <img id="izomterkep1" class="w-25" src="" alt="">
            <img id="izomterkep2" class="w-25" src="" alt="">
        </div>
        </div>
    </div>
    </section>

    </main>

    <?php
        include("footer.html");
    ?>

    <script src="js/profil.js"></script>
    <script>
        
        let sex = "<?php echo $nem; ?>";

        if (sex === 'man') {
            document.getElementById('izomterkep1').src = 'img/man_musculature_front.png';
            document.getElementById('izomterkep1').alt = "Férfi izomtérkép";
            document.getElementById('izomterkep2').src = "img/man_musculature_back.png";
            document.getElementById('izomterkep2').alt = "Férfi izomtérkép";
        } else if (sex === 'woman') {
            document.getElementById('izomterkep1').src = 'img/woman_musculature_front.png';
            document.getElementById('izomterkep1').alt = "Nő izomtérkép";
            document.getElementById('izomterkep2').src = "img/woman_musculature_back.png";
            document.getElementById('izomterkep2').alt = "Nő izomtérkép";
        } else {
            document.getElementById('izomterkep1').src = 'img/man_musculature_front.png';
            document.getElementById('izomterkep1').alt = "Férfi izomtérkép";
            document.getElementById('izomterkep2').src = "img/man_musculature_back.png";
            document.getElementById('izomterkep2').alt = "Férfi izomtérkép";
        }
        </script>
</body>
</html>