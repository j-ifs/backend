<?php
require_once("../database/connect.php");

//recebendo o json com os dados enviados pelo frontend
$storeData = file_get_contents('php://input');

/* escopo do json
{
    user: {
        "id": int,
        "role": string,
        "username": string,
        "password": string
        ?"class": string
    }
}
*/

//pegando o corpo do json
$requestBodyJson = json_decode($storeData, true);
$user = $requestBodyJson["user"];

//recebendo a coneão com o banco de dados
$databaseConnection = Connect();

$represetantId = null;

if($user["role"] == "representante") {

    $class = null;
    if(isset($user["class"])) {
        $class = $user["class"];
    } else {
        http_response_code(400);
        exit();
    }

    $createRepresentantSql = "INSERT INTO representante (id_turma) VALUE (?)";
    $createRepresentantStatement = $databaseConnection->prepare($createRepresentantSql);

    $createRepresentantStatement->bind_param("s", $class);
    $createRepresentantStatement->execute();

    $represetantId = $databaseConnection->insert_id;

} else if($user["role"] != "administrador") {
    http_response_code(400);
    exit();
}

//criando sql necessário para alterar os dados
$insertSql = "INSERT INTO adm (cargo, usuario, senha, id_representante) VALUES(?, ?, ?, ?);";

//preparando o sql para ser executado
$insertStatement = $databaseConnection->prepare($insertSql);

// executando o sql na query
$insertStatement->bind_param("sssi", $user["role"], $user["username"], $user["password"], $represetantId);

//verificando se a query foi bem sucedida
$noErrorOcorred = $insertStatement->execute();

$responseBody = [];
if ($noErrorOcorred) {
    $user["id"] = $databaseConnection->insert_id;
    $responseBody["user"] = $user;
    http_response_code(200);

} else {
    $responseBody["error"] = "Failed to store the new user";
    http_response_code(500);
}

echo json_encode($responseBody);
?>