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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetMotors</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
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
    <div class="header">
        <p class="logo">NetMotors</p>
        <ul>
            <li>
                <button class='nav-element'>
                    <a href="">
                        <p class="text-element">LANÇAMENTOS</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a href="">
                        <p class="text-element">COMPRAR</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a href="">
                        <p class="text-element">VENDER</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a href="pages/login.php">
                        <p class="text-element">
                            <?php 
                                if (is_null($_SESSION['user_id'])) {
                                    echo "ENTRAR";
                                } else {
                                    echo "SAIR";
                                }
                            ?>
                        </p>
                    </a>
                </button>
            </li>
        </ul>
    </div>
</body>

</html>