<?php

    require_once(__DIR__ . "/../database/connect.php");

    // Get post data
    $postData = file_get_contents('php://input');

    // Converts it into a PHP object
    $postBodyJson = json_decode($postData, true);
    /*
    Expected post data format:
    {
        "student": {
            "registration": int|string,
            "name": string,
            "class": string,
            "birthdate": string
        }
    }
    */
    $student = $postBodyJson["student"]; // Get student data

    $databaseConnection = Connect();
    $storeSql = "INSERT INTO jogador (nome, matricula, data_nascimento, id_turma) VALUES (?, ?, ?, ?);";

    $preparedStatement = $databaseConnection->prepare($storeSql);
    $preparedStatement->bind_param("siss", $student["name"], $student["registration"], $student["birthdate"], $student["class"]);

    // Reponse data array
    $responseData = [];
    $noErrorOccurred = $preparedStatement->execute();

    if($noErrorOccurred) {
        $student["id"] = $databaseConnection->insert_id; // Get last student id inserted

        $responseData["student"] = $student;
        http_response_code(200);

    } else {
        $responseData["error"] = "Could not create student";
        http_response_code(500); //Server fault
    }

    // End access
    $preparedStatement->close();  
    $databaseConnection->close();

    // Set response mime type
    header("Content-Type: application/json");

    // Writes reponse data
    echo json_encode($responseData);
?>