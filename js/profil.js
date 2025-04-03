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

    currentCalories += calories;
    displayCalories = calorieGoal-currentCalories;
    document.getElementById("calorie-text").textContent = displayCalories + " kcal maradt";

    calories = document.getElementById("calorieInput").value = 0;
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