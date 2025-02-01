<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="pages/login.php">Logout</a>
</body>
</html>