<?php
    require_once(__DIR__ . "/../auth/Filter.php");
    require_once(__DIR__ . "/../database/connect.php");

    Filter\AuthenticatedOnly();

    // Get post data
    $putData = file_get_contents('php://input');

    // Converts it into a PHP object
    $requestBodyJson = json_decode($putData, true);

    /*
    Expected request body:
    {
        "student": {
            "id": int,
            "registration": int|string,
            "name": string,
            "class": string,
            "birthdate": string
        }
    }
    */

    $student = $requestBodyJson["student"]; // Get student data

    $updateSql = "UPDATE jogador SET nome = ?, matricula = ?, data_nascimento = ?, id_turma = ? WHERE id_jogador = ?";

    $databaseConnection = Connect();
    $searchStatement = $databaseConnection->prepare($updateSql);

    $searchStatement->bind_param("sissi", $student["name"], $student["registration"], $student["birthdate"], $student["class"], $student["id"]);
    $noErrorOccurred = $searchStatement->execute();

    if($noErrorOccurred) {
        http_response_code(200);

    } else {
        $error = "Could not update student data";

        http_response_code(500);
        header("Content-Type: application/json");
        echo json_encode([ "error" => $error ]);
    }

    $databaseConnection->close();

?>