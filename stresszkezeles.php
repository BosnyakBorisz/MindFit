<?php

    session_start();

    if (!isset($_SESSION["email"])) {
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
?>

<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/strong.png"></link:icon>
    <title>Stresszkezelés</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #dbd5d5;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background: #181818;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        .cardstres {
            background-color: #2e302f;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative;
            overflow: visible;
            text-align: left;
            height: auto;
            display: flex;
            flex-direction: column;
            font-size: 16px;
            line-height: 1.8;
            justify-content: space-between;
        }
        .cardstres:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3);
        }
        .cardstres h2 {
            color: #2E7D32;
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .cardstres ul {
            padding: 0;
            list-style-type: none;
        }
        .cardstres ul li {
            margin-bottom: 12px;
        }
        .cardstres ul li:before {
            
            position: absolute;
            left: 0;
            color:#2E7D32 ;
            font-size: 18px;
        }
        .cardstres .card-footer {
            margin-top: 20px;
            font-size: 12px;
            font-weight: 600;
            width: 100%;
            color: #2E7D32;
            text-align: center;
        }
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        .social-icons a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            transition: transform 0.3s;
        }
        .social-icons a:hover {
            transform: scale(1.2);
        }
        .text{
            color:#dbd5d5;
            text-align:center;
        }
        
    </style>
</head>
<body>

    <header>
        <?php
        include("header.html")
        ?>
    </header>

        <h2 class="text">Stresszkezelés</h2>

    <div class="container">
        <div class="cardstres">
            <div>
                <h2>Rendszeres testmozgás</h2>
                <p>A sport és a fizikai aktivitás segít csökkenteni a stresszhormonokat és növeli a boldogsághormonok szintjét. Ajánlott mozgásformák: futás, jóga, úszás, súlyzós edzés vagy akár egy séta a természetben.</p>
            </div>
            <div class="card-footer">Ajánlott testmozgások</div>
        </div>
        <div class="cardstres">
            <div>
                <h2>Megfelelő alvás</h2>
                <p>Az elegendő és pihentető alvás elengedhetetlen a stressz kezeléséhez. Érdemes minden nap azonos időben lefeküdni és felkelni, valamint kerülni a képernyők használatát elalvás előtt.</p>
            </div>
            <div class="card-footer">Az alvás szerepe</div>
        </div>
        <div class="cardstres">
            <div>
                <h2>Pihentető hobbi és kikapcsolódás</h2>
                <p>Olyan tevékenységeket végezz, amelyek örömet okoznak, például olvasás, zenehallgatás, festés vagy kertészkedés. Ezek a hobbik segítenek feltöltődni.</p>
            </div>
            <div class="card-footer">Relaxáló hobbik</div>
        </div>
        <div class="cardstres">
            <div> 
                <h2>Légzőgyakorlatok</h2>
                <ul>
                    <li><strong>4-7-8 technika:</strong> Lélegezz be 4 másodpercig, tartsd bent 7 másodpercig, majd fújd ki 8 másodperc alatt. Ez segít a test ellazításában és a nyugodt állapot elérésében.</li>
                    <li><strong>Diafragmatikus (has) légzés:</strong> Mélyen lélegezz be az orrodon keresztül úgy, hogy a hasad kitáguljon, majd lassan fújd ki a levegőt a szádon keresztül. Ez csökkenti a szorongást és a vérnyomást, miközben elősegíti a relaxációt.</li>
                    <li><strong>Alternatív orrlyuk légzés:</strong> Az egyik orrlyukat befogva lélegezz be, majd a másik oldalon fújd ki. Ez segít az elme lecsendesítésében, javítja a koncentrációt és tisztítja az elmét.</li>
                </ul>
            </div>
            <div class="card-footer">Légzés technikák</div>
        </div>
        <div class="cardstres">
            <div>
                <h2>Meditáció</h2>
                <ul>
                    <li><strong>Mindfulness meditáció:</strong> Koncentrálj a jelen pillanatra, figyeld meg a gondolataidat ítélkezés nélkül, és fókuszálj a légzésedre. A mindfulness meditáció segít megszabadulni a felesleges gondolatoktól, és csökkenti a stresszt.</li>
                    <li><strong>Vezetett meditáció:</strong> Használj meditációs alkalmazásokat vagy hallgass vezetett meditációkat, amelyek segítenek a relaxációban. A vezetett meditációk segítenek elérni a mélyebb pihenést, miközben irányítják a gondolatokat.</li>
                    <li><strong>Mantra meditáció:</strong> Ismételj egy nyugtató szót vagy mondatot, például "béke" vagy "nyugalom", hogy segíts a koncentrációban és a megnyugvásban. A mantra meditáció segít az elme összpontosításában és a stressz csökkentésében.</li>
                    <li><strong>Vizualizációs technika:</strong> Képzeld el magad egy nyugodt helyen, például egy tengerparton vagy egy erdőben, és próbáld meg átélni az érzéseket. Ez a technika segíthet elterelni a figyelmet a stressztől és nyugodtabb állapotba hozni a testet és az elmét.</li>
                </ul>
            </div>
            <div class="card-footer">Meditációs módszerek</div>
        </div>
       
    </div>
    <?php
        include("footer.html")
    ?>
</body>
</html>
