<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
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
    <link rel="stylesheet" type="text/css" href="../css/sellcars.css">
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
    <!-- header -->
    <div class="header">
        <div id="left">
            <p class="logo">NetMotors</p>
            <p id="welcome">Bem-vindo
                <?php
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
                    <a href="../index.php">
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
                    <a href="./sellcars.php">
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
                            echo "href='../includes/logout.php'";
                        }
                        ?>>
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
    <h2 class='title-sellscars'>Cadastrar anúncio</h2>
    <div>
        <?php include('../components/sell_cars_form.php'); ?>
    </div>
    <div id="error-alert" style="display: none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); background-color: red; color: white; padding: 10px; border-radius: 5px; z-index: 1000;">
        <span id="error-message"></span>
        <button onclick="closeAlert()" style="margin-left: 10px; background: none; border: none; color: white; font-weight: bold;">X</button>
    </div>

    <script src='../js/select_brand_SellForm.js' ></script>
</body>

</html>