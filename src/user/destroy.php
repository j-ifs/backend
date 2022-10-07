<?php
require_once("../database/connect.php");

$id_usuario = $_GET["id_adm"];

$databaseConnection = connect();

$deleteSql = "DELETE FROM usuario WHERE id_adm = ?;";


$searchStatement = $databaseConnection->prepare($deleteSql);

$searchStatement = bin_param("i", $id_usuario);

$noErrorOcorred= $searchStatement->execute();

if ($noErrorOcorred) {

    http_response_code(200);

} else {

    http_response_code(500);
    
}
