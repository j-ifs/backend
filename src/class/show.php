<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $classId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT * FROM turma WHERE id_turma = ?;";

    $databaseConnection = Connect();

    $preapredStatement = $databaseConnection->prepare($searchSql);

    $preapredStatement->bind_param("s", $classId);
    $preapredStatement->execute();

    $searchQueryResult = $preapredStatement->get_result();

    $classData = $searchQueryResult->fetch_assoc();

    http_response_code(200);
    header("Content-Type: application/json");

    echo json_encode(
        [
            "class" => [
                "id" => $classData["id_turma"],
                "course" => $classData["curso"],
                "year" => $classData["ano"]
            ]
        ]
    );
?>