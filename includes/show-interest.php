<?php

session_start();
if (!isset($_SESSION['user_id']) && isset($_GET['ad_id'])) {
    $id = $_GET['ad_id'];
    header("Location: ../pages/ad-view.php?ad_id=$id");
    exit();
} else if (!isset($_SESSION["user_id"]) && !isset($_GET['ad_id'])) {
    header('Location: ../index.php');
    exit();
}

include '/var/www/html/concessionaria/includes/db.php';
try {
    $stmt = $conn->prepare("INSERT INTO interesse_compra (id_anuncio, cpf_interessado) VALUES (:id, :cpf)");
    $stmt->bindParam("id", $_GET['ad_id'], PDO::PARAM_INT);
    $stmt->bindParam('cpf', $_SESSION['user_id']);
    $stmt->execute();

    $ad = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Location: ../index.php');
} catch (PDOException $e) {
    $errorMessage = "Ocorreu um erro interno." . $e->getMessage();
}