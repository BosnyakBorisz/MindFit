document.getElementById("newsletter-form").addEventListener("submit", function (e) {
    e.preventDefault(); 

    const emailInput = document.getElementById("email");
    const email = emailInput.value;

    const formData = new FormData();
    formData.append("email", email);

    fetch("subscribe.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        emailInput.value = "";
    })
    .catch(error => {
    });
});