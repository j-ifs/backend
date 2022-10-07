<?php
require_once("../database/connect.php");

//recebendo o json com os dados enviados pelo frontend
$storeData = file_get_contents('php://input');

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
$requestBodyJson = json_decode($storeData, true);

//recebendo a coneão com o banco de dados
$databaseConnection = connect();

//criando sql necessário para alterar os dados
$insertSql = "INSERT INTO usuario(cargo, usuario, senha) VALUES(?, ?, ?);";

//preparando o sql para ser executado
$searchStatement = $databaseConnection->prepare($insertSql);

// executando o sql na query
$searchStatement = bin_param("ssi", $user["cargo"], $user["usuario"], $user["senha"]);

//verificando se a query foi bem sucedida
$noErrorOcorred = $searchStatement->execute();

if ($noErrorOcorred) {
    
    http_response_code(200);

} else {
    
    http_response_code(500);

}
