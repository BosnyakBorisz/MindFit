function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
}

async function confirmDelete() {
    let password = document.getElementById("passwordDelete").value;
    let errorMsg = document.getElementById("deletePassError");

    if (password.trim() === "") {
        errorMsg.innerText = "A jelszó mező nem lehet üres!";
        return;
    }

    try {
        let response = await fetch("delete_account.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ password: password })
        });

        let result = await response.json();

        if (result.success) {
            window.location.href = "logout.php";
        } else {
            errorMsg.innerText = result.error;
        }
    } catch (error) {
        errorMsg.innerText = "Hiba történt a szerverrel!";
    }
}