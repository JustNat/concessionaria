<?php

include '../includes/db.php';
$errorMessage = ''; // Inicializa a variável de erro

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $username = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['senha'];
    $confirmPassword = $_POST['confirm_password']; // Novo campo

    // Verifica se as senhas coincidem
    if ($password !== $confirmPassword) {
        $errorMessage = "As senhas não coincidem. Tente novamente."; // Mensagem de erro
    } else {
        // Criptografa a senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Preparar consulta para inserir os dados no banco
            $stmt = $conn->prepare("INSERT INTO usuario (cpf, nome, email, tipo, senha) VALUES (:cpf, :nome, :email, :tipo, :senha)");

            // Usando bindValue para evitar erro de referência
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':nome', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':tipo', 'com');
            $stmt->bindValue(':senha', $hashedPassword);

            $stmt->execute();

            // Redireciona após o sucesso
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            // Atribui a mensagem de erro do banco à variável de erro
            $errorMessage = "Erro ao cadastrar: " . $e->getMessage();
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
            <input type="text" id="cpf" name="cpf" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirm_password">Confirmar senha:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Cadastrar</button>
        </form>

        <div class="register-link">
            <p>Já tem uma conta?</p>
            <a href="login.php">Entre aqui</a>
        </div>
    </div>

    <!-- Inclusão do alert de erro -->
    <?php if ($errorMessage): ?>
        <div id="error-alert" class="alert">
            <div class="alert-content">
                <p class="error-message"><?php echo $errorMessage; ?></p>
                <button onclick="closealert()">Fechar</button>
            </div>
        </div>
    <?php endif; ?>

    <script src="../js/alert.js"></script>
</body>

</html>