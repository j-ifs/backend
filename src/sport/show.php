<?php

    require_once("../database/connect.php");

    $sportId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT * FROM modalidade WHERE id_modalidade = ?";

    $databaseConnection = Connect();
    $searchStatement = $databaseConnection->prepare($searchSql);

    $searchStatement->bind_param("i", $sportId);
    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $responseBody = [];

    if($searchResult->num_rows) {
        $sportData = $searchResult->fetch_assoc();

        $responseBody["sport"] = [
            "id" => $sportData["id_modalidade"],
            "name" => $sportData["nome"]
        ];

    } else {
        $responseBody["error"] = "Sport not found";
        http_response_code(404);
    }

    header("Content-Type: application/json");
    echo json_encode($responseBody);
?>