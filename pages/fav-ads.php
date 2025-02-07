<?php
session_start();


include '../includes/db.php';
try {
    $stmt = $conn->prepare(
        "SELECT interesse_compra.id_anuncio, anuncio.*, modelo.* 
        FROM interesse_compra 
        INNER JOIN anuncio ON id_anuncio = id
        INNER JOIN modelo ON anuncio.id_modelo = modelo.id
        WHERE cpf_interessado = :cpf"
    );
    $stmt->bindParam("cpf", $_SESSION['user_id']);
    $stmt->execute();

    $favAds = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = "Ocorreu um erro interno." . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Anúncios favoritados</title>
    <link rel="stylesheet" href="../css/fav-ads.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index_content.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-buttons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php
    include '../components/header.php';
    ?>

    <p id="title">Anúncios favoritados</p>

    <div id="fav-ads">
        <?php
        if (empty($favAds)) {
            echo '<p id="no-ads-p">Não há anúncios favoritados.</p>';
        } else {
            foreach ($favAds as $fav) {
                include '../components/inner_components/fav-ad.php';
            }
        }
        ?>
    </div>

</body>

</html>