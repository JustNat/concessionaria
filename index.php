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
        <div id="left">
            <p class="logo">NetMotors</p>
            <p id="welcome">Bem-vindo<?php 
                if (isset($_SESSION['user_id'])) {
                    echo ", {$_SESSION['nome']}.";
                } else {
                    echo ".";
                }
                ?>
            </p>
        </div>
        
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
                    <a 
                        <?php
                        if (!isset($_SESSION['user_id'])) {
                            echo "href='pages/login.php'";
                        } else {
                            echo "href='includes/logout.php'";
                        }
                        ?>
                    >
                        <p class="text-element">
                            <?php
                            if (!isset($_SESSION['user_id'])) {
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