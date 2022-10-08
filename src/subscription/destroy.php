<?php
    require_once("../database/connect.php");

    $subscriptionId = substr($_SERVER["PATH_INFO"], 1);

    $deleteSql = "DELETE FROM jogador_modalidade WHERE id = ?";

    $databaseConnection = Connect();
    $deleteStatement = $databaseConnection->prepare($deleteSql);

    $deleteStatement->bind_param("i", $subscriptionId);
    $noErrorOccurred = $deleteStatement->execute();

    if($noErrorOccurred) {
        http_response_code(200);

    } else {
        echo json_encode([ "error" => "Failed to delete subscription" ]);
        http_response_code(500);   
    }

?>