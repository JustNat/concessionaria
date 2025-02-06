<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMessage = '';
include 'E:\xampp\htdocs\concessionaria\includes\db.php';
include 'inner_components/ad.php';
$ads = [];

try {
    $stmt = $conn->prepare("SELECT anuncio.id, anuncio.id_modelo, anuncio.foto, anuncio.preco, anuncio.km, anuncio.gnv, modelo.nome, modelo.ano, modelo.id_marca, modelo.combustivel, modelo.cambio FROM anuncio INNER JOIN modelo ON anuncio.id_modelo = modelo.id WHERE aprovado = TRUE");
    $stmt->execute();

    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_GET['preco_min']) && isset($_GET['preco_max'])) {
        $preco_min = $_GET['preco_min'];
        $preco_max = $_GET['preco_max'];

        $ads = array_filter($ads, function ($ad) use ($preco_min, $preco_max) {
            return ($ad['preco'] >= $preco_min && $ad['preco'] <= $preco_max);
        });
    }

    if (isset($_GET['modelo'])) {
        $modelo = $_GET['modelo'];
        $ads = array_filter($ads, function ($ad) use ($modelo) {
            return (strpos(strtolower($ad['nome']), strtolower($modelo)) !== false);
        });
    }
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
    <script src='\concessionaria\js\filter.js'></script>
</div>
