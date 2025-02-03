<?php
session_start();
?>

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
                <a href="../index.php">
                    <p class="text-element">LANÇAMENTOS</p>
                </a>
            </button>
        </li>
        <li>
            <button class='nav-element'>
                <a href="./pages/register-ad.php">
                    <p class="text-element">VENDER</p>
                </a>
            </button>
        </li>
        <li>
            <button class='nav-element'>
                <a <?php
                if (!isset($_SESSION['user_id'])) {
                    echo "href='pages/login.php'";
                } else {
                    echo "href='includes/logout.php'";
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