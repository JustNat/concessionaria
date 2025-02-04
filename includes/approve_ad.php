<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ad_id'])) {
    $ad_id = filter_input(INPUT_POST, 'ad_id', FILTER_VALIDATE_INT);

    if ($ad_id === false) {
        echo "ID inválido.";
        exit();
    }

    try {
        $sql = "UPDATE anuncio SET aprovado = TRUE WHERE id_veiculo = :ad_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Anúncio aprovado com sucesso!";
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "Erro ao aprovar o anúncio.";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}
?>
