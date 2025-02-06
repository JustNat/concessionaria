<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMessage = '';
include '../includes/db.php';
try {
    $stmt = $conn->prepare("SELECT anuncio.*, modelo.nome, modelo.ano, modelo.id_marca, cidade.nome AS cidade_nome
    FROM anuncio 
    INNER JOIN modelo ON anuncio.id_modelo = modelo.id 
    INNER JOIN cidade ON anuncio.id_cidade = cidade.id
    WHERE aprovado = FALSE");
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
            include('inner_components/ad.admin.php');
        }
    }
    ?>
</div>