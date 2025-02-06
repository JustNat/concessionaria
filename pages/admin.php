<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /concessionaria/pages/login.php");
    exit();
}

if (isset($_SESSION['tipo']) && !$_SESSION['tipo'] == 'adm') {
    header("Location: /concessionaria/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetMotors</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/index_content.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-buttons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div>
        <!-- Header -->
        <?php include('../components/header.php'); ?>
    </div>
    <div class="top-buttons">
        <div><button class="btn-cadastrar">Cadastrar Marcas</button></div>
        <div><button class="btn-cadastrar">Cadastrar Modelos</button></div>
    </div>
    <!-- Admin-content -->
    <div>
        <?php include('../components/admin-content.php'); ?>
    </div>
</body>


</html>