<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['ad_id'])) {
    $adId = $_GET['ad_id'];
} else {
    header('Location: ../index.php');
}

include '/var/www/html/concessionaria/includes/db.php';
try {
    $stmt = $conn->prepare("SELECT anuncio.* , modelo.* FROM anuncio INNER JOIN modelo ON anuncio.id_modelo = modelo.id WHERE anuncio.id = :id");
    $stmt->bindParam("id", $adId, PDO::PARAM_INT);
    $stmt->execute();

    $ad = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($ad)) {
        header("Location: ../index.php");
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
    <link rel="stylesheet" href="../css/ad-view.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include '../components/header.php' ?>

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
            <a href=<?php 
                if (!isset($_SESSION['user_id'])) {
                    echo 'login.php';
                } else {
                    $cpf = $_SESSION['user_id'];
                    echo "../includes/show-interest.php?ad_id=" . $adId . "&cpf=" . $cpf;
                }
            ?>" style="text-decoration: none;">
                <p id="button-desc">Mostrar interesse</p>
            </a>
        </button>

    </div>

</body>

</html>