<?php

if (!isset($_GET['ad_id'])) {
    header('Location: ../index.php');
}

include 'db.php';
try {
    $stmt = $conn->prepare("DELETE FROM anuncio WHERE id = :id");
    $stmt->bindParam("id", $_GET['ad_id'], PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../index.php');
} catch (PDOException $e) {
    $errorMessage = "Ocorreu um erro interno." . $e->getMessage();
}