<?php
require_once("../database/connect.php");

$databaseConnection = connect();

$selectSql = "SELECT DISTINCT id_adm, cargo, usuario, IF(adm.id_representante IS NOT NULL, representante.id_turma, NULL) as id_turma 
                FROM adm, representante
                WHERE (adm.id_representante IS NULL OR adm.id_representante = representante.id_representante);";

$result = $databaseConnection->query($selectSql);

$responseBody = [];
if ($result) {
    $users = [];
    
    while($fetch = $result->fetch_assoc()) {

        $user = [
            "id" => (int) $fetch["id_adm"],
            "role" => $fetch["cargo"],
            "username" => $fetch["usuario"],
        ];

        if($class = $fetch["id_turma"]) {
            $user["class"] = $fetch["id_turma"];
        }

        $users[] = $user;
    }
    
    $responseBody["users"] = $users;
    http_response_code(200);

} else {
    $responseBody["error"] = "Could not fetch users data";
    http_response_code(500);
}

echo json_encode($responseBody);

?>