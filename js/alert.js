document.addEventListener("DOMContentLoaded", function() {
    const alertBox = document.getElementById("alert-box");
    const errorMessage = alertBox ? alertBox.getAttribute("data-error-message") : '';

    if (errorMessage) {
        showAlert(errorMessage, "error");
    }
});

// Função para exibir o alerta com a mensagem e a cor apropriada
function showAlert(message, type) {
    const alertBox = document.getElementById('alert-box');
    const messageSpan = document.getElementById('alert-message');
    alertBox.className = 'alert-box';
    if (type === 'success') {
        alertBox.classList.add('success');
    } else if (type === 'error') {
        alertBox.classList.add('error');
    }
    messageSpan.textContent = message;
    alertBox.style.display = 'block';
}

function closeAlert() {
    const alertBox = document.getElementById('alert-box');
    alertBox.style.display = 'none';
}