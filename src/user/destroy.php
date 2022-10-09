<?php
require_once("../database/connect.php");

$id_usuario = substr($_SERVER["PATH_INFO"], 1);

$databaseConnection = Connect();

$deleteSql = "DELETE FROM adm WHERE id_adm = ?;";


$deleteStatement = $databaseConnection->prepare($deleteSql);

$deleteStatement->bind_param("i", $id_usuario);

$noErrorOcorred= $deleteStatement->execute();

if ($noErrorOcorred) {

    http_response_code(200);

} else {

    http_response_code(500);
    
}
