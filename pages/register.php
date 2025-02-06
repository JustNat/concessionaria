<?php

include '../includes/db.php';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $username = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['senha'];
    $confirmPassword = $_POST['confirm_password'];

    // Verifica se as senhas coincidem
    if ($password !== $confirmPassword) {
        $errorMessage = "As senhas não coincidem. Tente novamente.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO usuario (cpf, nome, email, tipo, senha) VALUES (:cpf, :nome, :email, :tipo, :senha)");
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':nome', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':tipo', 'com');
            $stmt->bindValue(':senha', $hashedPassword);

            $stmt->execute();

            $stmt = $conn->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
            $stmt->bindValue(':cpf', $cpf);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Inicia a sessão e armazena as informações do usuário
            session_start();
            $_SESSION['user_id'] = $user['cpf'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['tipo'] = $user['tipo'];
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $errorMessage = "Este CPF já está cadastrado. Tente outro.";
            } else {
                $errorMessage = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/alert.css">
</head>

<body>
    <div class="register-container">
        <form method="POST" action="register.php">

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="11">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha">

            <label for="confirm_password">Confirmar senha:</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <button type="submit">Cadastrar</button>
        </form>

        <div class="register-link">
            <p>Já tem uma conta?</p>
            <a href="login.php">Entre aqui</a>
        </div>
    </div>

    <!-- exibido se houver erro -->
    <div id="alert-box" class="alert-box" style="display: none;" data-error-message="<?php echo htmlspecialchars($errorMessage); ?>">
        <div class="alert-content">
            <span id="alert-message"></span>
            <button id="close-alert" onclick="closeAlert()">Fechar</button>
        </div>
    </div>

    <script src="../js/alert.js"></script>
    <script src="../js/validations/register-validation.js"></script>
</body>

</html>