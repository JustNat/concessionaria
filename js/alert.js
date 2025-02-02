document.addEventListener("DOMContentLoaded", function() {
    const alertBox = document.getElementById("alert-box");

    // Verifica se a mensagem de erro existe no atributo 'data-error-message'
    const errorMessage = alertBox ? alertBox.getAttribute("data-error-message") : '';

    if (errorMessage) {
        showAlert(errorMessage, "error"); // Exibe o alerta com a mensagem de erro
    }
});

// Função para exibir o alerta com a mensagem e a cor apropriada
function showAlert(message, type) {
    const alertBox = document.getElementById('alert-box');
    const messageSpan = document.getElementById('alert-message');
    
    // Define a cor do alerta com base no tipo (error ou success)
    alertBox.className = 'alert-box'; // Reseta as classes
    if (type === 'success') {
        alertBox.classList.add('success');
    } else if (type === 'error') {
        alertBox.classList.add('error');
    }

    // Atribui a mensagem ao elemento
    messageSpan.textContent = message;

    // Exibe o alerta
    alertBox.style.display = 'block';
}

// Função para fechar o alerta ao clicar no botão
function closeAlert() {
    const alertBox = document.getElementById('alert-box');
    alertBox.style.display = 'none';
}