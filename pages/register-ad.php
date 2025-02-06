<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$errorMessage = '';
$marcas = [];
$modelos = [];
$id_marca_selecionada = "";
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

        $id_modelo = isset($_POST["id_modelo"]);
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

        $sql_anuncio = "INSERT INTO anuncio (id_usuario, id_cidade, descricao, preco, telefone, foto, dt_criacao, aprovado, placa, km, gnv, cor, novo, id_modelo) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW(), FALSE, ?, ?, ?, ?, ?, ?)";
        $stmt_anuncio = $conn->prepare($sql_anuncio);
        $stmt_anuncio->execute([$id_usuario, $id_cidade, $descricao, $preco, $telefone, $foto, $placa, $km, $gnv, $cor, $novo, $id_modelo]);

  
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetMotors</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-register.css">
    <link rel="stylesheet" type="text/css" href="../css/ad-buttons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- header -->
    <div class="header">
        <div id="left">
            <p class="logo">NetMotors</p>
            <p id="welcome">Bem-vindo
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo ", " . htmlspecialchars($_SESSION['nome']) . ".";
                } else {
                    echo ".";
                }
                ?>
            </p>
        </div>
        <ul>
            <li><button class='nav-element'><a href="../index.php">
                        <p class="text-element">LANÇAMENTOS</p>
                    </a></button></li>
            <li><button class='nav-element'><a href="">
                        <p class="text-element">COMPRAR</p>
                    </a></button></li>
            <li><button class='nav-element'><a <?php echo !isset($_SESSION['user_id']) ? "href='pages/login.php'" : "href='../includes/logout.php'"; ?>>
                        <p class="text-element"><?php echo !isset($_SESSION['user_id']) ? "ENTRAR" : "SAIR"; ?></p>
                    </a></button></li>
        </ul>
    </div>
    <h2 class='title-sellscars'>Cadastrar anúncio</h2>

    <div class="ad-button">
        <a href="?view=register">
            <button class="nav-element">
                <p class="text-element">Cadastrar Anúncio</p>
            </button>
        </a>
        <a href="?view=my-ads">
            <button class="nav-element">
                <p class="text-element">Meus Anúncios</p>
            </button>
        </a>
    </div>

    <div>
        <?php
        $view = isset($_GET['view']) ? $_GET['view'] : 'register'; // Padrão: 'register'
        
        if ($view === 'register') {
            include '../components/register-ad-form.php';
        } elseif ($view === 'my-ads') {
            include('../components/user-content.php');
        }
        ?>
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