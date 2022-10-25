<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $studentId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT jogador.*, turma.curso, turma.ano FROM jogador
                    INNER JOIN turma ON turma.id_turma = jogador.id_turma
                    WHERE jogador.id_jogador = ?";

    $databaseConnection = Connect();
    $searchStatement = $databaseConnection->prepare($searchSql);

    $searchStatement->bind_param("i", $studentId);
    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $responseBody = [];
    if($searchResult->num_rows) {
        $studentData = $searchResult->fetch_assoc();
        
        $responseBody["student"] = [
            "id" => (int) $studentData["id_jogador"],
            "name" => $studentData["nome"],
            "registration" => (int) $studentData["matricula"],
            "birthdate" => $studentData["data_nascimento"],
            "class" => [
                "id" => $studentData["id_turma"],
                "course" => $studentData["curso"],
                "year" => (int) $studentData["ano"]
            ]
        ];
    } else {
        $responseBody["error"] = "Student not found";
        http_response_code(404);
    }

    echo json_encode($responseBody);
?>