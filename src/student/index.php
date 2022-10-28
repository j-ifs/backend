<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $searchSql = "SELECT jogador.*, turma.curso, turma.ano FROM jogador
                    INNER JOIN turma ON turma.id_turma = jogador.id_turma";

    $databaseConnection = Connect();
    $searchResult = $databaseConnection->query($searchSql);

    $students = [];

    while($studentData = $searchResult->fetch_assoc()) {
        $students[] = [
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
    }

    echo json_encode([ "students" => $students ]);
?>