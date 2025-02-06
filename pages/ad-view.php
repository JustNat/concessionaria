<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_GET['ad_id'])) {
    $adId = $_GET['ad_id'];
} else {
    header('Location: ../index.php');
}

include '../includes/db.php';
try {
    $stmt = $conn->prepare("SELECT anuncio.id as id_anuncio, anuncio.* , modelo.* FROM anuncio INNER JOIN modelo ON anuncio.id_modelo = modelo.id WHERE anuncio.id = :id");
    $stmt->bindParam("id", $adId, PDO::PARAM_INT);
    $stmt->execute();

    $ad = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($ad)) {
        header("Location: ../index.php");
    }
    $interestsUsers = [];
    if ($_SESSION['user_id'] == $ad[0]['id_usuario']) {
        $stmt = $conn->prepare("SELECT usuario.* FROM interesse_compra INNER JOIN usuario ON cpf_interessado = cpf WHERE id_anuncio = :id");
        $stmt->bindParam("id", $_GET['ad_id'], PDO::PARAM_INT);
        $stmt->execute();

        $interestsUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->prepare('SELECT * FROM interesse_compra WHERE cpf_interessado = :user AND id_anuncio = :anuncio');
        $stmt->bindParam('user', $_SESSION['user_id']);
        $stmt->bindParam('anuncio', $_GET['ad_id'], PDO::PARAM_INT);
        $stmt->execute();

        $isInterested = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $errorMessage = "Ocorreu um erro interno." . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?php echo $ad[0]['descricao'] ?></title>
    <link rel="stylesheet" type="text/css" href="../css/ad-view.css">
    <link rel="stylesheet" type="text/css" href="../css/interest-section-ad-view.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-buttons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
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
            if (isset($_SESSION['user_id']) && $_SESSION['tipo'] == 'adm') {
                echo '<li>
                    <button class="nav-element">
                        <a href="admin.php">
                            <p class="text-element">Painel Administrativo</p>
                        </a>
                    </button>
                </li>';
            }

            if (isset($_SESSION['user_id'])) {
                echo '<li>
                    <button class="nav-element">
                        <a href="fav-ads.php">
                            <p class="text-element">Anúncios favoritados</p>
                        </a>
                    </button>
                </li>';
            }
            ?>
            <li>
                <button class='nav-element'>
                    <a href="../index.php">
                        <p class="text-element">LANÇAMENTOS</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a href="register-ad.php">
                        <p class="text-element">VENDER</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a <?php
                    if (!isset($_SESSION['user_id'])) {
                        echo "href='login.php'";
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

    <div id="container">

        <div id="desc-price">
            <p id="description">
                <?php echo $ad[0]['id_marca'] . " " . $ad[0]['nome'] . " " . $ad[0]['ano'] . " " . $ad[0]['versao'] ?>
            </p>
            <p id="price">R$<?php echo number_format($ad[0]['preco'], 2, ',', '.') ?></p>
        </div>

        <img src="<?php echo $ad[0]['foto'] ?>" width="900px" height="600px" style="border-radius: 25px;">

        <div id="model-info">
            <p id="fuel"><?php
            switch ($ad[0]['combustivel']) {
                case 'f':
                    echo "Flex";
                    break;
                case 'g':
                    echo "Gasolina";
                    break;
                case "h":
                    echo "Híbrido";
                    break;
                case "e":
                    echo "Elétrico";
                    break;
                case "d":
                    echo "Diesel";
                    break;
                case "a":
                    echo "Álcool";
                    break;
            }
            ?></p>
            <p id="transmission">
                <?php
                switch ($ad[0]['cambio']) {
                    case 'e':
                        echo "Automático elétrico";
                        break;
                    case 'a':
                        echo 'Automático';
                        break;
                    case 'm':
                        echo 'Manual';
                        break;
                }
                ?>
            </p>
            <p id="seats"><?php echo $ad[0]['qtd_lugares'] . " lugares" ?></p>
            <p id="hp"><?php echo $ad[0]['cv'] . " cavalos" ?></p>
            <p id="cc"><?php echo $ad[0]['cc'] . " cilindradas" ?></p>
            <p id="doors"><?php echo $ad[0]['portas'] . " portas" ?></p>
        </div>

        <div id="vehicle-info">
            <p id="plate">
                <?php echo "Fim da placa:" . " " . substr($ad[0]['placa'], -1) ?>
            </p>
            <p id="km">
                <?php echo number_format($ad[0]['km'], 0, ',', '.') . " km" ?>
            </p>
            <p id="gnv">
                <?php
                if ($ad[0]["gnv"] == 1) {
                    echo "Com GNV";
                } else {
                    echo "Sem GNV";
                }
                ?>
            </p>
            <p id="color">
                <?php echo $ad[0]["cor"] ?>
            </p>
            <p id="new">
                <?php
                if ($ad[0]["novo"] == 1) {
                    echo "Carro novo";
                } else {
                    echo "Carro usado";
                }
                ?>
            </p>
        </div>

        <button id="show-interest">
            <?php
            if (!isset($_SESSION['user_id'])) {
                echo "<a href='login.php'><p id='button-desc'>Fazer login</p></a>";
            } else if ($_SESSION['user_id'] == $ad[0]['id_usuario']) {
                echo "<a href='../includes/delete-ad.php?ad_id=$adId'><p id='button-desc'>Excluir anúncio</p></a>";
            } else {
                if (!empty($isInterested)) {
                    echo "<p id='button-desc'>Anúncio já marcado para interesse.</p>";
                } else {
                    $cpf = $_SESSION['user_id'];
                    echo "<a href='../includes/show-interest.php?ad_id=" . $ad[0]['id_anuncio'] . "&cpf=$cpf'><p id='button-desc'>Mostrar interesse</p></a>";
                }
            }
            ?>
        </button>

        <p style="font-family: 'Raleway'; font-size: x-large; color: black; margin-top: 20px; margin-bottom: 5px;">Usuários que demonstraram interesse</p>
        <div id="interested-container">
            <?php
            if ($_SESSION['user_id'] == $ad[0]['id_usuario']) {
                if (empty($interestsUsers)) {
                    echo "<p style='font-family: Raleway; font-size: x-large;'>Sem usuários interessados até o momento.</p>";
                } else {
                    foreach ($interestsUsers as $user) {
                        include('../components/inner_components/interested-users.php');
                    }
                }
            }
            ?>
        </div>

    </div>

</body>

</html>