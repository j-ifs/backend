<?php
    require_once("../database/connect.php");

    $postData = file_get_contents("php://input");

    $postBodyJson = json_decode($postData, true);
    $subscription = $postBodyJson["subscription"];

    $insertSql = "INSERT INTO jogador_modalidade (id_turma, id_jogador, id_modalidade) VALUE (?, ?, ?)";

    $databaseConnection = Connect();
    $insertStatement = $databaseConnection->prepare($insertSql);

    $insertStatement->bind_param("sii", $subscription["class"], $subscription["student"], $subscription["sport"]);
    $noErrorOccurred = $insertStatement->execute();

    $responseBody = [];

    if($noErrorOccurred) {
        $subscription["id"] = $databaseConnection->insert_id;

        $responseBody["subscription"] = $subscription;    

    } else {
        $responseBody["error"] = "Could not complete the subscription";
        http_response_code(500);
    }

    header("Content-Type: application/json");
    echo json_encode($responseBody);

?>