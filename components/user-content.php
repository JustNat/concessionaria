<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMessage = '';
$userId = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT anuncio.foto, anuncio.preco, veiculo.km, modelo.nome, modelo.ano, modelo.id_marca
                            FROM anuncio WHERE anuncio.id_usuario = :userId");
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
            echo "<button class='ad-container'
                data-preco='" . htmlspecialchars($ad['preco']) . "'
                data-km='" . htmlspecialchars($ad['km']) . "'
                data-combustivel='" . htmlspecialchars($ad['combustivel']) . "'
                data-cambio='" . htmlspecialchars($ad['cambio']) . "'
                data-gnv='" . htmlspecialchars($ad['gnv']) . "'>
                    <div class='ad'>
                        <a href='pages/ad-view.php?ad_id=" . urlencode($ad['id']) . "'>
                            <img src='" . htmlentities($ad['foto']) . "' class='ad-img' width='180px' height='140px' crossorigin='anonymous' />
                            <p class='car-model'>" . htmlspecialchars($ad['nome']) . "</p>
                            <p class='car-brand'>" . htmlspecialchars($ad['id_marca']) . "</p>
                            <div class='car-year-km'>
                                <p>" . htmlspecialchars($ad['ano']) . "</p>
                                <p>" . number_format($ad['km'], 0, ',', '.') . "</p>
                            </div>
                            <p class='price'>" . number_format($ad['preco'], 2, ',', '.') . "</p>
                        </a>
                    </div>
                </button>";
        }
    }
    ?>
</div>