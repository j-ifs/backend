<?php
require_once("../auth/Filter.php");
require_once("../database/connect.php");

Filter\AdminOnly();

$id_usuario = substr($_SERVER["PATH_INFO"], 1);

$databaseConnection = Connect();

$selectSqlEspecificy = "SELECT id_adm, cargo, nome, usuario, senha, IF (id_representante IS NULL, NULL, (
                                SELECT representante.id_turma FROM representante 
                                WHERE representante.id_representante = adm.id_representante
                                LIMIT 0, 1
                            )
                        ) AS id_turma
                        FROM adm WHERE id_adm = ?";


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
        "name" => $userData["nome"],
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
