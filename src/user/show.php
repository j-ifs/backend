<?php
require_once("../database/connect.php");

$id_usuario = $_GET["id_adm"];

$databaseConnection = connect();

$selectSqlEspecificy = "SELECT * FROM usuario WHERE id_adm = ?;";


$searchStatement = $databaseConnection->prepare($selectSqlEspecificy);

$searchStatement = bin_param("i", $id_usuario);

$searchStatement->execute();

$searchResult = $searchStatement->get_result();

$response = [];

if ($searchResult->num_rows()) {

    $userData = $searchResult->fetch_assoc();

    $response["user"] = [
        "id" => $userData["id_adm"],
        "role" => $userData["cargo"],
        "username" => $userData["usuario"]
    ];

    if ($class = $userData["id_turma"]) {
        $response["user"]["class"] = $class;
    }


    $json = json_encode($response);

    echo $json;

    http_response_code(200);
} else {
    http_response_code(500);
}
