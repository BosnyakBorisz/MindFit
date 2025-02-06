<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <div id="step1">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <h2>Regisztráció</h2>
                <label>Név:</label>
                <input type="text" id="name" class="form-control">
                <label>Kor:</label>
                <input type="number" id="age" class="form-control">
                <label>Nem:</label>
                <select id="gender" class="form-control">
                    <option>Férfi</option>
                    <option>Nő</option>
                    <option>Egyéb</option>
                </select>
                <label>Fizikai bizbasz:  mostani és cél | sulyt konnyen szedsz vagy adsz le | hány hét alatt szeretnel | milyen kondi |  hány edzés egy héten | milyen hosszu | érzékeny testrész | suly magassag </label>
                <input type="text" id="" class="form-control">
            </form>
            <button class="btn btn-primary mt-3" onclick="nextStep()">Tovább</button>
        </div>

        <div id="step2" class="hidden">
            <h2>Életmódbeli kérdések</h2>
            <label>Milyen célokat szeretnél elérni?</label>
            <select class="form-control">
                <option>Fogyás</option>
                <option>Izomnövelés</option>
                <option>Egészséges életmód</option>
            </select>
            <button class="btn btn-success mt-3">Befejezés</button>
        </div>
    </div>

    <script>
        function nextStep() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }
    </script>
</body>
</html>
