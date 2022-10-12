<?php
require_once("../database/connect.php");

$id_usuario = substr($_SERVER["PATH_INFO"], 1);

$databaseConnection = Connect();

$searchSql = "SELECT id_representante FROM adm WHERE id_adm = ?";

$searchStatement = $databaseConnection->prepare($searchSql);
$searchStatement->bind_param("i", $id_usuario);

$searchStatement->execute();
$searchResult = $searchStatement->get_result();

$agentId = null;
if($searchResult->num_rows) {
    $searchData = $searchResult->fetch_assoc();
    $agentId = $searchData["id_representante"];

} else{
    http_response_code(404);
    exit();
}

$deleteSql = "DELETE FROM adm WHERE id_adm = ?;";


$deleteStatement = $databaseConnection->prepare($deleteSql);

$deleteStatement->bind_param("i", $id_usuario);

$noErrorOccurred= $deleteStatement->execute();

if($agentId && $noErrorOccurred) {
    $noErrorOccurred = $databaseConnection->query("DELETE FROM representante WHERE id_representante = $agentId");
}

if ($noErrorOccurred) {

    http_response_code(200);
} else {

    http_response_code(500);
    
}
