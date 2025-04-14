let lastUpdateDate = localStorage.getItem('lastUpdateDate');
let todayDate = new Date().toLocaleDateString(); 

//Kalória kiszámítás

let BMR;
if (nem === "Férfi") {
    BMR = 10 * testsuly + 6.25 * magassag - 5 * kor + 5;
} 
else if (nem === "Nő") {
    BMR = 10 * testsuly + 6.25 * magassag - 5 * kor - 161;
}

const activityMultipliers = {
    1: 1.2,         // Ülő életmód
    2: 1.375,       // Enyhén aktív életmód
    3: 1.375,       // Enyhén aktív életmód
    4: 1.55,        // Mérsékelten aktív életmód
    5: 1.725,       // Nagyon aktív életmód
    6: 1.9,         // Rendkívül aktív életmód
    7: 1.9          // Rendkívül aktív életmód
};

const activityFactor = activityMultipliers[activity];
const TDEE = BMR * activityFactor;

let calorieGoal = 0;
if (typeof cel !== "undefined") {
    if (cel === "Fogyás") {
        calorieGoal = Math.round(TDEE * 0.8);
    } else if (cel === "Formában tartás" || cel === "Fogyás és izomtömegnövelés") {
        calorieGoal = Math.round(TDEE);
    } else if (cel === "Izomnövelés" || cel === "Sportólói karrier elkezdése") {
        calorieGoal = Math.round(TDEE * 1.1);
    }
}

// Kalóriaszámláló
let currentCalories = parseFloat(localStorage.getItem("currentCalories")) || 0;
let firstKcal = localStorage.getItem("firstKcal") === "false" ? false : true; 

if (lastUpdateDate !== todayDate) {
    currentCalories = 0;
    firstKcal = true; 
    localStorage.setItem("lastUpdateDate", todayDate);
    localStorage.setItem("currentCalories", currentCalories);
    localStorage.setItem("firstKcal", true);
}

updateCalorieText();

function addCalories() {
    let calorieInput = document.getElementById("calorieInput");
    let calories = Number(calorieInput.value);

    if (!isNaN(calories) && calories > 0) {
        currentCalories += calories;
        localStorage.setItem("currentCalories", currentCalories);
        if (currentCalories >= calorieGoal && firstKcal) {
            firstKcal = false;
            localStorage.setItem("firstKcal", false);
            triggerConfetti();
        }

        updateCalorieText(); 

        calorieInput.value = "";
    }
}
function updateCalorieText() {
    let displayCalories = calorieGoal - currentCalories;
    let textElement = document.getElementById("calorie-text");

    if (displayCalories >= 0) {
        textElement.textContent = `${displayCalories} kcal maradt`;
    } else {
        textElement.textContent = `+${Math.abs(displayCalories)} kcal`;
    }

    // progress frissítése
    let progress = (currentCalories / calorieGoal) * 100;
    if (progress > 100) progress = 100;

    document.querySelector('.progress-circle').style.background = 
        `conic-gradient(#00ff00 ${progress}%, #ddd ${progress}%)`;
}

// Lépésszámláló
const stepsGoal = 10000;
let currentSteps = parseInt(localStorage.getItem("currentSteps")) || 0;
let firstStep = localStorage.getItem("firstStep") === "false" ? false : true;

if (lastUpdateDate !== todayDate) {
    currentSteps = 0;
    firstStep = true;
    localStorage.setItem("lastStepsUpdateDate", todayDate);
    localStorage.setItem("currentSteps", currentSteps);
    localStorage.setItem("firstStep", true);
}

updateStepsDisplay();

function updateStepsDisplay() {
    document.getElementById("stepsCount").textContent = currentSteps;
    const progress = (currentSteps / stepsGoal) * 100;
    document.getElementById("stepbarbar").style.width = progress + "%";
}

function lepesHozzaAd() {
    const input = document.getElementById("stepsInput").value;

    if (input && input > 0) {
        currentSteps += parseInt(input);
        localStorage.setItem("currentSteps", currentSteps);
        updateStepsDisplay();

        if (currentSteps >= stepsGoal && firstStep) {
            firstStep = false;
            localStorage.setItem("firstStep", false);
            triggerConfetti();
        }
    }

    document.getElementById("stepsInput").value = 0;
}

// Vízszámláló
const goal = testsuly * 35 + ((edzesHossz / 30) * 350);
let currentWaterIntake = parseInt(localStorage.getItem("currentWaterIntake")) || 0;
let firstWater = localStorage.getItem("firstWater") === "false" ? false : true;

if (lastUpdateDate !== todayDate) {
    currentWaterIntake = 0;
    firstWater = true;
    localStorage.setItem("lastUpdateDate", todayDate);
    localStorage.setItem("currentWaterIntake", currentWaterIntake);
    localStorage.setItem("firstWater", true);
}

document.getElementById("waterGoal").textContent = `Cél: ${(goal / 1000).toFixed(1)}l`;

updateWaterProgress();

function setWaterProgress(value) {
    const progressBar = document.getElementById("waterbarbar");
    value = Math.max(0, Math.min(100, value));
    progressBar.style.height = value + "%";
}

function vizHozzaAd() {
    const input = document.getElementById("vizinput").value;

    if (input && input > 0) {
        currentWaterIntake += parseInt(input);
        const progress = (currentWaterIntake / goal) * 100;
        localStorage.setItem("currentWaterIntake", currentWaterIntake);

        setWaterProgress(progress);

        if (currentWaterIntake >= goal && firstWater) {
            firstWater = false;
            localStorage.setItem("firstWater", false);
            triggerConfetti();
        }
    }

    document.getElementById("vizinput").value = 0;
}

function updateWaterProgress() {
    const progress = (currentWaterIntake / goal) * 100;
    setWaterProgress(progress);
}


function triggerConfetti() {
    const count = 200,
    defaults = {
        origin: { y: 0.7 },
    };

    function fire(particleRatio, opts) {
    confetti(
        Object.assign({}, defaults, opts, {
        particleCount: Math.floor(count * particleRatio),
        })
    );
    }

    fire(0.25, {
    spread: 26,
    startVelocity: 55,
    });

    fire(0.2, {
    spread: 60,
    });

    fire(0.35, {
    spread: 100,
    decay: 0.91,
    scalar: 0.8,
    });

    fire(0.1, {
    spread: 120,
    startVelocity: 25,
    decay: 0.92,
    scalar: 1.2,
    });

    fire(0.1, {
    spread: 120,
    startVelocity: 45,
    });
}


const motivaciosSzovegek = [
    "Ne hagyd, hogy a fáradtság megállítson! Minden egyes ismétlés közelebb visz a céljaidhoz. 💪",

    "A siker nem véletlen. Minden edzés egy új lépés a legjobb verziód felé. 🏋️‍♂️",

    "Ma is erősebb vagy, mint tegnap! Ne hagyd, hogy bármi elvonja a figyelmedet a céljaidról. 🔥",

    "A fájdalom csak ideiglenes, de a büszkeség örökké tart. Tarts ki! 💯",

    "Minden egyes csepp izzadság egy lépés a változás felé. Ne állj meg! 🚀",

    "Amikor úgy érzed, hogy nem bírod tovább, tudd, hogy akkor vagy a legközelebb a sikerhez! 🌟",

    "Ne csak álmodj a változásról, dolgozz érte! Az erő benned van. 🔨",

    "A kemikáliekkel teli világban az igazi erő a kitartásban rejlik. Minden edzés hozzátesz a legjobb verzióhoz! 💥",

    "A mai edzés alapja a holnapi sikered. Ne hagyd ki! 🌱",

    "Hozd ki a legtöbbet magadból – minden perc, minden ismétlés számít! ⏳",

    "Minden egyes edzés új erőt ad. Tudd, hogy a határaidat most léped át! 🔝",

    "Ha fáj, az jó jel! Az igazi fejlődés ott kezdődik, ahol a komfortzónád véget ér. 💪",

    "Ne add fel! Minden egyes perc közelebb hoz a céljaidhoz. ⏳",

    "A kitartásod a legnagyobb erő! A változás nem jön könnyen, de megéri. ⚡",

    "A nehézségek csak megerősítenek. Még akkor is, ha úgy tűnik, hogy nem megy tovább. 🔥",

    "Minden edzés lehetőséget ad arra, hogy erősebb legyél. Légy büszke arra, hogy megteszed! 🏆",

    "Az edzés a legjobb befektetés, amit magadba tehetsz. Ne hagyd ki! 💸",

    "Ne várj a tökéletes pillanatra. A változás most kezdődik! ⏰",

    "A határaid nem ott vannak, ahol most érzékeled őket. Tedd próbára őket! 🚀",

    "Ne számold az ismétléseket, hanem éld meg őket! Minden egyes mozdulat hozzájárul a célhoz. 🔄",

    "A szorgalom és a kitartás meghozza gyümölcsét. Ma is egy lépéssel közelebb kerültél! 🌱",

    "Ne a tökéletességre törekedj, hanem a fejlődésre. Minden nap új lehetőség. 🏅",

    "A fájdalom ideiglenes, de az eredmények örökre megmaradnak. 🔥",

    "A mai edzés a holnapi erőd. Ne állj meg most! 💥",

    "Az igazi erő nem csak a súlyokban, hanem a fejedben is rejlik. 🧠",

    "Minden edzés egy új esély a növekedésre. Ne hagyd ki a lehetőséget! 📈",

    "A legnagyobb versenyt nem másokkal vívod, hanem saját magaddal. 🏁",

    "Amikor meg akarsz állni, emlékezz, miért kezdted el! 💡",

    "Az eredmény nem véletlen. Az eredmény kemikális összetevője a kemény munka! 💪",

    "Még egy ismétlés! Még egy szett! Még egy lépés a siker felé! 🎯",

    "A cél nem az, hogy erősebb legyél, hanem hogy a legjobb verziót hozd ki magadból. 🏋️‍♀️",

    "A változás nem az edzés során történik, hanem azután, amikor már úgy érzed, nem bírod tovább. 💥",

    "Tudd, hogy a legnagyobb győzelmek a legnehezebb pillanatokból születnek. 🏆",

    "A sikerhez vezető út nem könnyű, de megéri! Tartsd a fókuszt és sose állj meg! ✨",

    "A legnehezebb napok építenek a legerősebb emberekké. Tarts ki! 🔥",
]

const today = new Date().toISOString().slice(0, 10);

let hash = 0;
for (let i = 0; i < today.length; i++) {
  hash += today.charCodeAt(i);
}

const index = hash % motivaciosSzovegek.length;
document.getElementById("napiMoti").innerText = `"${motivaciosSzovegek[index]}"`;