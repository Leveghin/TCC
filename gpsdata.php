<?php 

// Inclui o arquivo de configurações do banco de dados
require 'config.php';

// Recupera as coordenadas de latitude e longitude da requisição GET
$lat = $_GET['lat'];
$lng = $_GET['lng'];

// Exibe as coordenadas
echo "Latitude: " . $lat . "<br>";
echo "Longitude: " . $lng . "<br>";

// Prepara a query SQL para inserir os dados de GPS na tabela
$sql = "INSERT INTO tbl_gps(lat, lng, created_date) 
        VALUES('".$lat."', '".$lng."', '".date("Y-m-d H:i:s")."')";

// Executa a query e verifica se foi bem-sucedida
if ($db->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $db->error;
} else {
    // Se bem-sucedida, exibe o ID do registro inserido
    echo "Record added successfully. ID is: " . $db->insert_id;
}

?>
