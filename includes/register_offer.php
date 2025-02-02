<?php
include '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "Usuário não autenticado!"]);
    exit;
}

$id_usuario = $_SESSION["user_id"];
$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id_modelo = $_POST["id_modelo"];
        $placa = $_POST["placa"];
        $km = $_POST["km"];
        $gnv = isset($_POST["gnv"]) ? 1 : 0;
        $cor = $_POST["cor"];
        $id_cidade = $_POST["id_cidade"];
        $preco = $_POST["preco"];
        $telefone = $_POST["telefone"];
        $foto = $_POST["foto"];
        $descricao = $_POST["descricao"];
        $novo = ($km == 0) ? 1 : 0; // Correção para ser um valor inteiro

        // Inserir veículo
        $sql_veiculo = "INSERT INTO veiculo (id_modelo, placa, km, gnv, cor, novo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_veiculo = $conn->prepare($sql_veiculo);
        $stmt_veiculo->execute([$id_modelo, $placa, $km, $gnv, $cor, $novo]);
        $id_veiculo = $conn->lastInsertId();

        // Inserir anúncio
        $sql_anuncio = "INSERT INTO anuncio (id_veiculo, id_usuario, id_cidade, descricao, telefone, foto, preco, dt_criacao, aprovado) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), FALSE)";
        $stmt_anuncio = $conn->prepare($sql_anuncio);
        $stmt_anuncio->execute([$id_veiculo, $id_usuario, $id_cidade, $descricao, $telefone, $foto, $preco]);

        $response = ["success" => true, "message" => "Anúncio cadastrado com sucesso!"];
    } catch (PDOException $e) {
        $response = ["error" => "Erro: " . $e->getMessage()];
    }
}

echo json_encode($response);
?>