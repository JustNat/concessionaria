document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const cpf = document.getElementById("cpf").value.trim();
            const nome = document.getElementById("nome").value.trim();
            const email = document.getElementById("email").value.trim();
            const senha = document.getElementById("senha").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            let valid = true;
            
            clearErrors();

            if (!cpf || !nome || !email || !senha || !confirmPassword) {
                showAlert("Todos os campos são obrigatórios.", "error");
                valid = false;
            } else if (!validateCPF(cpf)) {
                showAlert("CPF inválido. Insira um CPF válido.", "error");
                valid = false;

            } else if (!validateNome(nome)) {
                showAlert("Nome Inválido", "error");
                valid = false;

            } else if (!validateSenha(senha)) {
                showAlert("Senha muito curta!, insira uma senha maior", "error");
                valid = false;

            } else if (!validateEmail(email)) {
                showAlert("Email inválido. Insira um email válido.", "error");
                valid = false;
            } else if (senha !== confirmPassword) {
                showAlert("As senhas não coincidem.", "error");
                valid = false;
            }
            if (valid) {
                form.submit();
            }
        });
    }
});

// Função para validar CPF
function validateCPF(cpf) {
    const regex = /^\d{11}$/;
    return regex.test(cpf);
}

// Função para validar senha com pelo menos 6 caracteres
function validateSenha(senha) {
    return senha.length >= 6;
}

// Função para validar e-mail
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Função para validar o nome (somente letras e espaços)
function validateNome(nome) {
    const regex = /^[A-Za-záéíóúãõçÁÉÍÓÚÃÕÇ\s]+$/;
    return regex.test(nome) && nome.length >= 2;
}

// Função para exibir o alerta
function showAlert(message, type) {
    const alertBox = document.getElementById("alert-box");
    const messageSpan = document.getElementById("alert-message");

    alertBox.className = "alert-box";
    if (type === "success") {
        alertBox.classList.add("success");
    } else if (type === "error") {
        alertBox.classList.add("error");
    }

    messageSpan.textContent = message;
    alertBox.style.display = "block";
}

// Função para limpar os erros
function clearErrors() {
    const alertBox = document.getElementById("alert-box");
    alertBox.style.display = "none";
}
