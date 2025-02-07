<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['ad_id'])) {
    header('Location: ../index.php');
}

include '../includes/db.php';

$errorMessage = '';

$currentAd = [];
try {
    $stmt = $conn->prepare("SELECT anuncio.*, modelo.* FROM anuncio INNER JOIN modelo ON anuncio.id_modelo = modelo.id  WHERE anuncio.id = :id");
    $stmt->bindParam('id', $_GET['ad_id']);
    $stmt->execute();

    $currentAd = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
}


$marcas = [$currentAd['id_marca']];
$modelos = [];
$id_marca_selecionada = $currentAd['id_marca'];
$cidades = [];
$response = ["success" => false, "message" => ""];

function getCidades($conn)
{
    $sql = "SELECT id, nome FROM cidade";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMarcas($conn)
{
    $sql = "SELECT id FROM marca";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getModelos($conn, $id_marca)
{
    $sql = "SELECT id, nome, versao, ano FROM modelo WHERE id_marca = :id_marca";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$cidades = getCidades($conn);
$marcas = getMarcas($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_marca'])) {
    $id_marca_selecionada = $_POST['id_marca'];
    $modelos = getModelos($conn, $id_marca_selecionada);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_modelo'])) {
    try {
        $conn->beginTransaction();

        $id_modelo = $_POST["id_modelo"];
        $id_cidade = $_POST["id_cidade"];
        $placa = $_POST["placa"];
        $km = $_POST["km"];
        $gnv = isset($_POST["gnv"]) ? 1 : 0;
        $cor = $_POST["cor"];
        $preco = $_POST["preco"];
        $telefone = $_POST["telefone"];
        $foto = $_POST["foto"];
        $descricao = $_POST["descricao"];
        $id_usuario = $_SESSION["user_id"] ?? null;

        $novo = ($km == 0) ? 1 : 0;

        if (!$id_usuario) {
            echo json_encode(["success" => false, "message" => "Erro: Usuário não autenticado."]);
            exit();
        }

        $sql_check_modelo = "SELECT COUNT(*) FROM modelo WHERE id = ?";
        $stmt_check_modelo = $conn->prepare($sql_check_modelo);
        $stmt_check_modelo->execute([$id_modelo]);
        if ($stmt_check_modelo->fetchColumn() == 0) {
            echo json_encode(["success" => false, "message" => "Erro: Modelo não encontrado."]);
            exit();
        }

        $sql_check_cidade = "SELECT COUNT(*) FROM cidade WHERE id = ?";
        $stmt_check_cidade = $conn->prepare($sql_check_cidade);
        $stmt_check_cidade->execute([$id_cidade]);
        if ($stmt_check_cidade->fetchColumn() == 0) {
            echo json_encode(["success" => false, "message" => "Erro: Cidade não encontrada."]);
            exit();
        }

        $sql_anuncio = "UPDATE anuncio
                        SET id_cidade = ?, descricao = ?, preco = ?, telefone = ?, foto = ?, placa = ?, km = ?, gnv = ?, cor = ?, novo =?, id_modelo = ?
                        WHERE id = ?";
        $stmt_anuncio = $conn->prepare($sql_anuncio);
        $stmt_anuncio->execute([$id_cidade, $descricao, $preco, $telefone, $foto, $placa, $km, $gnv, $cor, $novo, $id_modelo, $_GET['ad_id']]);

        $conn->commit();
        echo json_encode(["success" => true, "message" => "Anúncio cadastrado com sucesso!"]);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>
        <?php ?>
    </title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-buttons.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="header">
        <div id="left">
            <p class="logo">NetMotors</p>
            <p id="welcome"><?php
            if (isset($_SESSION['user_id'])) {
                echo " Bem-vindo , {$_SESSION['nome']}.";
            } else {
                echo "";
            }
            ?>
            </p>
        </div>
        <ul>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['tipo'] == 'adm') {
                echo '<li>
                    <button class="nav-element">
                        <a href="admin.php">
                            <p class="text-element">Painel Administrativo</p>
                        </a>
                    </button>
                </li>';
            }

            if (isset($_SESSION['user_id'])) {
                echo '<li>
                    <button class="nav-element">
                        <a href="fav-ads.php">
                            <p class="text-element">Anúncios favoritados</p>
                        </a>
                    </button>
                </li>';
            }
            ?>
            <li>
                <button class='nav-element'>
                    <a href="../index.php">
                        <p class="text-element">LANÇAMENTOS</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a href="register-ad.php">
                        <p class="text-element">VENDER</p>
                    </a>
                </button>
            </li>
            <li>
                <button class='nav-element'>
                    <a <?php
                    if (!isset($_SESSION['user_id'])) {
                        echo "href='login.php'";
                    } else {
                        echo "href='../includes/logout.php'";
                    }
                    ?>>
            <p class="text-element">
                            <?php
                            if (!isset($_SESSION['user_id'])) {
                                echo "ENTRAR";
                            } else {
                                echo "SAIR";
                            }
                            ?>
                        </p>
                    </a>
                </button>
            </li>
        </ul>
    </div>

    <div class='display-form'>
        <form method="POST" id='marca-form'>
            <label for="marca">Selecione a Marca:</label>
            <select name="id_marca" id="marca" onchange="this.form.submit()" required>
                <option value="">Selecione uma marca</option>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?= htmlspecialchars($marca['id']); ?>" <?= ($marca['id'] == $id_marca_selecionada) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($marca['id']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <form action="" method="POST" id="cadastro-form">
            <input type="hidden" name="id_marca" value="<?= htmlspecialchars($id_marca_selecionada); ?>">
            <label for="modelo">Selecione o Modelo:</label>
            <select name="id_modelo" id="modelo" required>
            <option value="">Selecione um modelo</option>
            <?php foreach ($modelos as $modelo): ?>
                <option value="<?= htmlspecialchars($modelo['id']); ?>">
                    <?= htmlspecialchars($modelo['nome'] . " " . $modelo['versao'] . " " . $modelo['ano']); ?>
                </option>
            <?php endforeach; ?>
        </select>

            <div class="veicle-element">
                <div class="half-width">
                    <label for="placa">Placa:</label>
                    <input type="text" name="placa" id="placa" required
                        value="<?= htmlspecialchars($currentAd['placa']) ?>">
                </div>
                <div class="half-width">
                    <label for="km">Km Atual:</label>
                    <input type="number" name="km" id="km" required value="<?= $currentAd['km']; ?>">
                </div>
                <div class="checkbox-option">
                    <label for="gnv">Possui GNV:</label>
                    <input type="checkbox" name="gnv" id="gnv" value="<?= $currentAd['km']; ?>">
                </div>
            </div>

            <div class="veicle-element">
                <div class="half-width">
                    <label for="cor">Cor:</label>
                    <input type="text" name="cor" id="cor" placeholder="Digite a cor do veículo" required value="<?= $currentAd['cor']; ?>">
                </div>
                <div class="half-width">
                    <label for="id_cidade">Cidade:</label>
                    <select name="id_cidade" id="id_cidade" required>
                        <option value="">Selecione a cidade</option>
                        <?php foreach ($cidades as $cidade): ?>
                            <option value="<?= htmlspecialchars($cidade['id']); ?>">
                                <?= htmlspecialchars($cidade['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="city-element">
                <div class="full-width">
                    <label for="preco">Preço do veículo:</label>
                    <input type="number" name="preco" id="preco" required value="<?= $currentAd['preco']; ?>">
                </div><br><br>
                <div class="full-width">
                    <label for="telefone">Telefone (com DDD):</label>
                    <input type="text" name="telefone" id="telefone" required value="<?= $currentAd['telefone']; ?>">
                </div><br><br>
                <div class="full-width">
                    <label for="foto">Foto do veículo (URL):</label>
                    <input type="text" name="foto" id="foto" required value="<?= $currentAd['foto']; ?>">
                </div><br><br>
            </div>

            <div class="description-element">
                <div class="full-width">
                    <label for="descricao">Descrição do Anúncio:</label><br>
                    <textarea name="descricao" id="descricao" rows="4" cols="50" required value="<?= $currentAd['descricao']; ?>"></textarea>
                </div>
            </div><br><br>
            <button class="button-sellscars" type="submit">Atualizar Anúncio</button>
        </form>
    </div>

    <div id="alert-box" class="alert-box" style="display: none;"
        data-error-message="<?php echo htmlspecialchars($errorMessage); ?>">
        <div class="alert-content">
            <span id="alert-message"></span>
            <button id="close-alert" onclick="closeAlert()">Fechar</button>
        </div>
    </div>
    <script src="../js/validations/ad-from-validation.js"></script>

    <!-- Impede o envio do form e tambem reseta o form -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("cadastro-form").addEventListener("submit", function (event) {
                event.preventDefault();

                let formData = new FormData(this);

                fetch("", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            document.getElementById("cadastro-form").reset();
                        } else {
                            alert("Erro: " + data.message);
                        }
                    })
                    .catch(error => console.error("Erro:", error));
            });
        });
    </script>

</body>

</html>