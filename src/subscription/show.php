<?php
    require_once("../database/connect.php");

    $subscriptionId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT * FROM jogador_modalidade WHERE id = ?";

    $databaseConnection = Connect();

    $searchStatement = $databaseConnection->prepare($searchSql);
    
    $searchStatement->bind_param("i", $subscriptionId);
    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $responseBody = [];
    if($searchResult->num_rows) {
        $subscriptionData = $searchResult->fetch_assoc();

        $responseBody["subscription"] = [
            "id" => $subscriptionData["id"],
            "student" => $subscriptionData["id_jogador"],
            "sport" => $subscriptionData["id_modalidade"],
            "class" => $subscriptionData["id_turma"]
        ];

    } else {
        $responseBody["error"] = "Subscription not found";
        http_response_code(404);
    }

    echo json_encode($responseBody);
?>