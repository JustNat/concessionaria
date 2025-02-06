<div class="header">
    <div id="left">
        <p class="logo">NetMotors</p>
        <p id="welcome"><?php
        if (isset($_SESSION['user_id'])) {
            echo " Bem-vindo , {$_SESSION['nome']}.";
        } else {
            echo "";
        }
        ?>
        </p>
    </div>
    <ul>
        <?php
        // Verifica se o usuário é do tipo 'adm' antes de mostrar o painel administrativo
        if (isset($_SESSION['user_id']) && $_SESSION['tipo'] == 'adm') {
            echo '<li>
                    <button class="nav-element">
                        <a href="/concessionaria/pages/admin.php">
                            <p class="text-element">Painel Administrativo</p>
                        </a>
                    </button>
                </li>';
        }

        if (isset($_SESSION['user_id'])) {
            echo '<li>
                    <button class="nav-element">
                        <a href="pages/fav-ads.php">
                            <p class="text-element">Anúncios favoritados</p>
                        </a>
                    </button>
                </li>';
        }
        ?>
        <li>
            <button class='nav-element'>
                <a href="/concessionaria/index.php">
                    <p class="text-element">LANÇAMENTOS</p>
                </a>
            </button>
        </li>
        <li>
            <button class='nav-element'>
                <a href="/concessionaria/pages/register-ad.php">
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