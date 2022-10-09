<?php
require_once("../database/connect.php");

$id_usuario = substr($_SERVER["PATH_INFO"], 1);

$databaseConnection = Connect();

$selectSqlEspecificy = "SELECT id_adm, cargo, usuario, IF(adm.id_representante IS NOT NULL, representante.id_turma, NULL) as id_turma 
                            FROM adm, representante
                            WHERE id_adm = ? AND (adm.id_representante IS NULL OR adm.id_representante = representante.id_representante);";


$searchStatement = $databaseConnection->prepare($selectSqlEspecificy);

$searchStatement->bind_param("i", $id_usuario);

$searchStatement->execute();

$searchResult = $searchStatement->get_result();

$response = [];

if ($searchResult->num_rows) {

    $userData = $searchResult->fetch_assoc();

    $response["user"] = [
        "id" => $userData["id_adm"],
        "role" => $userData["cargo"],
        "username" => $userData["usuario"]
    ];

    if ($class = $userData["id_turma"]) {
        $response["user"]["class"] = $class;
    }

    http_response_code(200);
} else {
    $response["error"] = "User not found";
    http_response_code(404);
}

header("Content-Type: application/json");
$json = json_encode($response);

echo $json;
