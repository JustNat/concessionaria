<?php

include '../includes/db.php';
$errorMessage = '';  // Inicializando a variável de erro

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
            header("Location: ../index.php");
            exit();
        } else {
            $errorMessage = "Email ou senha incorretos.";  // Atribuindo erro de login
        }
    } catch (PDOException $e) {
        // Captura o erro de banco de dados e exibe a mensagem
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
    <div class="login-container">
        <h2>Bem-vindo de volta!</h2>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
        <div class="register-link">
            <p>Ainda não tem uma conta?</p>
            <a href="register.php">Cadastre-se aqui</a>
        </div>
    </div>

    <!-- Modal de erro, exibido se houver erro -->
    <?php if ($errorMessage): ?>
        <div id="error-alert" class="alert">
            <div class="alert-content">
                <p class="error-message"><?php echo $errorMessage; ?></p>
                <button onclick="closealert()">Fechar</button>
            </div>
        </div>
    <?php endif; ?>

    <script src="../js/alert.js"></script> <!-- Script da popup -->
</body>

</html>