<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $searchSql= "SELECT * FROM turma";

    $databaseConnection = Connect();

    $searchQueryResult = $databaseConnection->query($searchSql);

    $classes = [];
    while($classData = $searchQueryResult->fetch_assoc()) {
        $classes[] = [
            "id" => $classData["id_turma"],
            "course" => $classData["curso"],
            "year" => $classData["ano"]
        ];
    }

    http_response_code(200);
    header("Content-Type: application/json");

    echo json_encode([ "classes" => $classes ]);
?>