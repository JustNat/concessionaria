<?php

include '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obter cidades
$sql_cidades = "SELECT id, nome FROM cidade";
$stmt_cidades = $conn->prepare($sql_cidades);
$stmt_cidades->execute();
$cidades = $stmt_cidades->fetchAll(PDO::FETCH_ASSOC);

// Obter marcas
$sql_marcas = "SELECT id FROM marca";
$stmt_marcas = $conn->prepare($sql_marcas);
$stmt_marcas->execute();
$marcas = $stmt_marcas->fetchAll(PDO::FETCH_ASSOC);

$marcas = [];
$modelos = [];
$id_marca_selecionada = "";

// Buscar todas as marcas no banco
$sql = "SELECT id FROM marca";
$stmt = $conn->prepare($sql);
$stmt->execute();
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se o usuário escolheu uma marca, buscar os modelos correspondentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_marca'])) {
    $id_marca_selecionada = $_POST['id_marca'];

    $sql = "SELECT nome FROM modelo WHERE id_marca = :id_marca";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_marca', $id_marca_selecionada, PDO::PARAM_INT);
    $stmt->execute();
    $modelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<form method="POST">
    <!-- SELECT de MARCA -->
    <label for="marca">Selecione a Marca:</label>
    <select name="id_marca" id="marca" onchange="this.form.submit()">
        <option value="">Selecione uma marca</option>
        <?php foreach ($marcas as $marca): ?>
            <option value="<?= $marca['id']; ?>" <?= ($marca['id'] == $id_marca_selecionada) ? 'selected' : ''; ?>>
                <?= $marca['id']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<form action="../includes/register_offer.php" method="POST">

    <div class="veicle-element">
        <!--  Manter a marca selecionada -->
        <input type="hidden" name="id_marca" value="<?= $id_marca_selecionada; ?>">

        <!-- SELECT de MODELO (carregado com PHP) -->
        <label for="modelo">Selecione o Modelo:</label>
        <select name="id_modelo" id="modelo">
            <option value="">Selecione um modelo</option>
            <?php foreach ($modelos as $modelo): ?>
                <option value="<?= $modelo['nome']; ?>"><?= $modelo['nome']; ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Placa do Veículo -->
        <div class="half-width">
            <label for="placa">Placa:</label>
            <input type="text" name="placa" id="placa" required>
        </div>

        <!-- Km Atual do Veículo -->
        <div class="half-width">
            <label for="km">Km Atual:</label>
            <input type="number" name="km" id="km" required>
        </div>

        <!-- Possui GNV (Booleano) -->
        <div class="checkbox-option">
            <label for="gnv">Possui GNV:</label>
            <input type="checkbox" name="gnv" id="gnv" value="1">
        </div>
    </div>

    <div class="veicle-element">
        <!-- Cor do Veículo -->
        <div class="half-width">
            <label for="cor">Cor:</label>
            <input type="text" name="cor" id="cor" placeholder="Digite a cor do veículo" required>
        </div>

        <!-- id_cidade -->
        <div class="half-width">
            <label for="id_cidade">Cidade:</label>
            <select name="id_cidade" id="id_cidade" required>
                <option value="">Selecione a cidade</option>
                <?php
                if (count($cidades) > 0) {
                    foreach ($cidades as $row) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhuma cidade encontrada</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="city-element">
        <!-- Preço do Anúncio -->
        <div class="full-width">
            <label for="preco">Preço do veículo:</label>
            <input type="number" name="preco" id="preco" required>
        </div><br><br>

        <!-- Telefone com DDD -->
        <div class="full-width">
            <label for="telefone">Telefone (com DDD):</label>
            <input type="text" name="telefone" id="telefone" required>
        </div><br><br>

        <!-- URL da Foto -->
        <div class="full-width">
            <label for="foto">Foto do veículo (URL):</label>
            <input type="text" name="foto" id="foto" required>
        </div><br><br>
    </div>

    <!-- Descrição do Anúncio -->
    <div class="description-element">
        <div class="full-width">
            <label for="descricao">Descrição do Anúncio:</label><br>
            <textarea name="descricao" id="descricao" rows="4" cols="50" required></textarea>
        </div>
    </div><br><br>
    <button class="button-sellscars" type="submit">Cadastrar Anúncio</button>
</form>
