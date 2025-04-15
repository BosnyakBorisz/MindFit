<!DOCTYPE html>
<html lang="hu">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/strong.png"></link:icon>
    <title>Adatkezelési Tájékoztató</title>
    <style>
        body {
            line-height: 1.6;
            background-color:#000000;
        }
        h1, h2 {
            color: #dbd5d5;
            text-align: center;
        }
        ul {
            padding-left: 20px;
        }
        p, li {
            font-size: 1rem;
        }
        .adatkez {
            color: #dbd5d5;
            max-width: 800px;
            margin: 10px;
            background-color:#181818;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <title>Adatkezelési Tájékoztató - MindFit</title>
</head>
<body>

    <?php 
        include("header.html");
    ?>

    <div class="container adatkez mx-auto">
        <h1>Adatkezelési Tájékoztató</h1>
        

        <h2>A. Kezelt adatok és céljuk</h2>
        <p>Az alábbi adatokat kezeljük annak érdekében, hogy teljes körű szolgáltatást nyújtsunk fitnesz oldalunk látogatóinak és regisztrált felhasználóinak.</p>
        <ul>
            <li><strong>Név:</strong> Az edzéstervek és szolgáltatások személyre szabása.</li>
            <li><strong>E-mail cím:</strong> Hírek, ajánlatok és fontos információk küldése.</li>
            <li><strong>Telefonszám:</strong> Konzultációs és ügyfélszolgálati célokra.</li>
            <li><strong>Edzési adatok:</strong> A fejlődés nyomon követése és személyre szabott tanácsadás.</li>
        </ul>

        <h2>B. Adatkezelés jogalapja és időtartama</h2>
        <p>Adataidat az <strong>önkéntes hozzájárulásod</strong> alapján kezeljük, amelyet bármikor visszavonhatsz.</p>
        <p>Az adatokat a hozzájárulás visszavonásáig vagy az adatkezelési cél megszűnéséig tároljuk.</p>

        <h2>C. Érintetti jogok</h2>
        <ul>
            <li><strong>Hozzáférési jog:</strong> Megtekintheted, milyen adatokat tárolunk rólad.</li>
            <li><strong>Helyesbítés joga:</strong> Kérheted pontatlan adataid javítását.</li>
            <li><strong>Törlés joga:</strong> Kérheted adataid törlését.</li>
            <li><strong>Korlátozás joga:</strong> Kérheted adatkezelésed korlátozását.</li>
            <li><strong>Adathordozhatóság:</strong> Kérheted adataid átadását más szolgáltatónak.</li>
            <li><strong>Tiltakozás joga:</strong> Tiltakozhatsz az adatkezelés ellen.</li>
        </ul>

        <h2>D. Jogorvoslati lehetőségek</h2>
        <p>Ha úgy érzed, hogy adataid kezelése jogsértő, panaszt tehetsz a <strong>Nemzeti Adatvédelmi és Információszabadság Hatóságnál (NAIH)</strong> vagy jogi útra terelheted az ügyet.</p>
        <p><strong>NAIH elérhetőségei:</strong></p>
        <p>Levelezési cím: 1363 Budapest, Pf. 9.<br>
        Székhely: 1055 Budapest, Falk Miksa utca 9-11.<br>
        E-mail: ugyfelszolgalat@naih.hu</p>

        <p>Ha kérdésed van, vedd fel velünk a kapcsolatot: <strong>turrmindfit@gmail.com</strong></p>
    </div>

    <?php 
        include("footer.html");
    ?>
</body>
</html>