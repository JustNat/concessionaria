document.getElementById("login-form").addEventListener("submit", function(e) {
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var valid = true;
    var errorMessage = '';

    if (!email || !validateEmail(email)) {
        valid = false;
        errorMessage = "Por favor, insira um e-mail válido.";
    }

    if (!senha) {
        valid = false;
        errorMessage = "Por favor, insira sua senha.";
    } else if (!validateSenha(senha)) {
        showAlert("Senha muito curta!, insira uma senha maior", "error");
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
        alert(errorMessage);
    } 
});

function validateEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}

function validateSenha(senha) {
    return senha.length >= 6;
}
