<?php

include '../includes/db.php';
$errorMessage = '';

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['senha'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            session_start();
            $_SESSION['user_id'] = $user['cpf'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['tipo'] = $user['tipo'];
            header("Location: ../index.php");
            exit();
        } else {
            $errorMessage = "Email ou senha incorretos.";  // Preenche a mensagem de erro
        }
    } catch (PDOException $e) {
        $errorMessage = "Erro de banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/alert.css">
</head>

<body>
    <div class='body-form-login'>

        <!-- Formulario de login -->
        <div class="login-container">
            <h2>Bem-vindo de volta!</h2>
            <form id="login-form" method="POST" action="login.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha">

                <button type="submit">Entrar</button>
            </form>
            <div class="register-link">
                <p>Ainda não tem uma conta?</p>
                <a href="register.php">Cadastre-se aqui</a>
            </div>
        </div>

        <div id="alert-box" class="alert-box" style="display: none;" data-error-message="<?php echo htmlspecialchars($errorMessage); ?>">
            <div class="alert-content">
                <span id="alert-message"></span>
                <button id="close-alert" onclick="closeAlert()">Fechar</button>
            </div>
        </div>
    </div>
    <script src="../js/validations/login-validation.js"></script>
    <script src="../js/alert.js"></script>
</body>

</html>