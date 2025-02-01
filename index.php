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
    <link rel="stylesheet" href="css/sideMenu.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div>
        <!-- Menu Lateral -->
        <div>
            <?php include './components/side_menu.php'; ?>
        </div>

        <!-- Conteúdo Principal -->
        <div class="content">
            <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
            <a href="includes/logout.php">Logout</a>
        </div>
    </div>

    <script src="/concessionaria/js/sideMenu.js"></script>
</body>

</html>