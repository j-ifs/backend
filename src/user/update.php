<?php
require_once("../database/connect.php");

//recebendo o json com os dados enviados pelo frontend
$putData = file_get_contents('php://input');

/** escopo do json
 *   {
 *     $user{
 *          "cargo" : string,
 *          "usuario" : string,
 *          "senha" : int,
 *          "id_adm" : int
 *          }
 *   }
 */

//pegando o corpo do json
$requestBodyJson = json_decode($putData, true);
$user = $requestBodyJson["user"];

if($user["role"] != "administrador" && $user["role"] != "representante") {
    http_response_code(400);
    exit();
}

//recebendo a coneão com o banco de dados
$databaseConnection = Connect();

//criando sql necessário para alterar os dados
$updateSql = "UPDATE adm SET cargo = ?, usuario = ?, senha = ? WHERE id_adm = ?;";

//preparando o sql para ser executado
$updateStatement = $databaseConnection->prepare($updateSql);

// executando o sql na query
$updateStatement->bind_param("sssi", $user["role"], $user["username"], $user["password"], $user["id"]);

//verificando se a query foi bem sucedida
$noErrorOcorred = $updateStatement->execute();

if ($noErrorOcorred) {
    http_response_code(200);

    echo json_encode($requestBodyJson);
    
} else {
    http_response_code(500);
}
