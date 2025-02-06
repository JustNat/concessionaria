<?php

include 'includes/db.php';

$errorMessage = '';

$currentAd = [];
try {
    $stmt = $conn->prepare("SELECT anuncio.*, modelo.id_marca FROM anuncio INNER JOIN modelo ON anuncio.id_modelo = modelo.id  WHERE anuncio.id = 1");
    $stmt->execute();

    $currentAd = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
}

print_r($currentAd);


?>