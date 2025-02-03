<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetMotors</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/index_content.css">
    <link rel="stylesheet" type="text/css" href="css/ad-buttons.css">
    <link rel="stylesheet" href="css/sideMenu.css">
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
    <!-- Header -->
    <?php include('./components/header.php'); ?>
        <!-- Side Menu -->
    <div>
        <?php include('./components/side_menu.php'); ?>

        <!-- Main Content -->
        <?php include('./components/index_content.php'); ?>
    </div>
    <script src='js/sideMenu.js'></script>
</body>

</html>