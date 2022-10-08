<?php
    require_once("../database/connect.php");

    $searchSql = "SELECT * FROM jogador";

    $databaseConnection = Connect();
    $searchResult = $databaseConnection->query($searchSql);

    $students = [];

    while($studentData = $searchResult->fetch_assoc()) {
        $students[] = [
            "id" => (int) $studentData["id_jogador"],
            "name" => $studentData["nome"],
            "registration" => (int) $studentData["matricula"],
            "birthdate" => $studentData["data_nascimento"],
            "class" => $studentData["id_turma"]
        ];
    }

    echo json_encode([ "students" => $students ]);
?>