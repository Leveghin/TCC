<?php
// Definições de conexão com o banco de dados
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'id21478704_dados');
define('DB_PASSWORD', 'banco123@W');
define('DB_NAME', 'id21478704_banco');

// Definindo o fuso horário padrão
date_default_timezone_set('America/Sao_Paulo');

// Tentando estabelecer conexão com o banco de dados
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificando se a conexão foi bem-sucedida
if ($db->connect_errno) {
    echo "Connection to database failed: " . $db->connect_error;
    exit();
}
?>
