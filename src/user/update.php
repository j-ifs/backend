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

//recebendo a coneão com o banco de dados
$databaseConnection = connect();

//criando sql necessário para alterar os dados
$updateSql = "UPDATE usuario SET cargo = ?, usuario = ?, senha = ? WHERE id_adm = ?;";

//preparando o sql para ser executado
$searchStatement = $databaseConnection->prepare($updateSql);

// executando o sql na query
$searchStatement = bin_param("ssii", $user["cargo"], $user["usuario"], $user["senha"], $user["id_adm"]);

//verificando se a query foi bem sucedida
$noErrorOcorred = $searchStatement->execute();

if ($noErrorOcorred) {
    http_response_code(200);

    echo($requestBodyJson);
    
} else {
    http_response_code(500);
}
