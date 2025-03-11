function setCaloriesProgress(currentCalories, goalCalories) {

    const circle = document.querySelector(".progress-circle");
    const text = document.querySelector(".progress-text");

    let percentage = (currentCalories / goalCalories) * 100;
    let angle = (percentage / 100) * 360;

    circle.style.background = `conic-gradient(var(--b) ${angle}deg, #ddd ${angle}deg)`;
    text.textContent = `${currentCalories} kcal \n remaining`;
}

setCaloriesProgress(1200, 2000);

    function setWaterProgress(value) {
    const progressBar = document.getElementById("waterbarbar");

    value = Math.max(0, Math.min(100, value));
    progressBar.style.height = value + "%";
    }

setWaterProgress(50);