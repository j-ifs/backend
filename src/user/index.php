<?php
require_once("../database/connect.php");

$databaseConnection = connect();

$selectSql = "SELECT id_adm, cargo, usuario, senha, IF (id_representante IS NULL, NULL, (
                        SELECT representante.id_turma FROM representante 
                        WHERE representante.id_representante = adm.id_representante
                        LIMIT 0, 1
                    )
                ) AS id_turma
                FROM adm";

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

header("Content-Type: application/json");
echo json_encode($responseBody);

?>