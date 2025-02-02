document.getElementById("login-form").addEventListener("submit", function(e) {
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var valid = true;
    var errorMessage = '';

    // Verificar se o e-mail é válido
    if (!email || !validateEmail(email)) {
        valid = false;
        errorMessage = "Por favor, insira um e-mail válido.";
    }

    // Verificar se a senha foi preenchida
    if (!senha) {
        valid = false;
        errorMessage = "Por favor, insira sua senha.";
    }

    // Se algum erro ocorrer, exibe uma mensagem de erro e impede o envio do formulário
    if (!valid) {
        e.preventDefault();
        alert(errorMessage);
    }
});

// Função para validar o formato do e-mail
function validateEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}
