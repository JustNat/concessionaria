<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMessage = '';
$userId = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT anuncio.foto, anuncio.preco, veiculo.km, modelo.nome, modelo.ano, modelo.id_marca
                            FROM anuncio 
                            INNER JOIN veiculo ON anuncio.id_veiculo = veiculo.id 
                            INNER JOIN modelo ON veiculo.id_modelo = modelo.nome
                            WHERE anuncio.id_usuario = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = "Ocorreu um erro interno." . $e->getMessage();
}

?>

<div id="main-content">
    <?php
    if (empty($ads)) {
        echo "<h1 style='margin-left: 20px; font-family: Raleway, serif;'>Não há anúncios ativos.</h1>";
    } else if ($errorMessage) {
        echo "<p>$errorMessage</p>";
    } else {
        foreach ($ads as $ad) {
            include('inner_components/ad.php');
        }
    }
    ?>
</div>