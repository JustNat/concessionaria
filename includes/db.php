<?php
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("Arquivo .env não encontrado!");
    }

    $env = parse_ini_file($filePath);
    if (!$env) {
        throw new Exception("Erro ao carregar o arquivo .env");
    }

    return $env;
}

try {
        $env = loadEnv(__DIR__. '/../.env');
    
        $host = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $username = $env['DB_USER'];
        $password = $env['DB_PASS'];
        $port = $env['DB_PORT'] ?? '5432';
    
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
}
?>
