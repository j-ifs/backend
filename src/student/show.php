<?php
    require_once("../database/connect.php");

    $studentId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT * FROM jogador WHERE id_jogador = ?";

    $databaseConnection = Connect();
    $searchStatement = $databaseConnection->prepare($searchSql);

    $searchStatement->bind_param("i", $studentId);
    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $responseBody = [];
    if($searchResult->num_rows) {
        $studentData = $searchResult->fetch_assoc();
        
        $responseBody["student"] = [
            "id" => $studentData["id_jogador"],
            "name" => $studentData["nome"],
            "registration" => $studentData["matricula"],
            "birthdate" => $studentData["data_nascimento"],
            "class" => $studentData["id_turma"]
        ];
    } else {
        $responseBody["error"] = "Student not found";
        http_response_code(404);
    }

    echo json_encode($responseBody);
?>