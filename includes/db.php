<?php

/*   Usar este modelo no arquivo .env !

DB_HOST='localhost'
DB_PORT='5432'
DB_NAME='concessionaria'
DB_USER='postgres'
DB_PASS=''

*/

// Função para carregar variáveis do arquivo .env
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
        // Carregar variáveis do .env
        $env = loadEnv('E:/xampp/htdocs/concessionaria/.env');
    
        // Configuração do banco de dados
        $host = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $username = $env['DB_USER'];
        $password = $env['DB_PASS'];
        $port = $env['DB_PORT'] ?? '5432'; // Porta padrão
    
        // Conexão com PostgreSQL
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
}
?>
