
<?php 

// Crie um arquivo .env com suas credenciais usando o modelo:
// DB_HOST=localhost
// DB_PORT=5432
// DB_NAME=bd_name
// DB_USER=user
// DB_PASS=senha.

function loadEnv($filePath){
    if (!file_exists($filePath)) {
        throw new Exception("Arquivo .env não encontrado: $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        // Separar chave e valor
        list($key, $value) = explode('=', $line, 2);

        // Definir variável no ambiente
        putenv(trim($key) . '=' . trim($value));
    }
}


try {
    loadEnv(__DIR__ . '/.env');
    
    // Agora, você pode acessar as variáveis de ambiente
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $database = getenv('DB_NAME');
    $port = getenv('DB_PORT');

    echo "Conectando ao banco em $host como $user...";

    $conn = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if (!$conn) {
        echo "Erro na conexão: " . pg_last_error();
    } else {
        echo "Conexão bem-sucedida!";
    }
} catch (Exception $e) {
    echo "Erro ao carregar o .env: " . $e->getMessage();
}