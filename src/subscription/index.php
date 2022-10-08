<?php
    require_once("../database/connect.php");

    $searchSql = "SELECT * FROM jogador_modalidade";

    $databaseConnection = Connect();

    $searchResult = $databaseConnection->query($searchSql);

    $subscriptions = [];
    while($subscriptionData = $searchResult->fetch_assoc()) {
        $subscriptions[] = [
            "id" => $subscriptionData["id"],
            "student" => $subscriptionData["id_jogador"],
            "sport" => $subscriptionData["id_modalidade"],
            "class" => $subscriptionData["id_turma"]
        ];
    }

    header("Content-Type: application/json");
    echo json_encode([ "subscriptions" => $subscriptions ]);
?>