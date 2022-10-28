<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $studentId = substr($_SERVER["PATH_INFO"], 1);

    $deleteSql = "DELETE FROM jogador WHERE id_jogador = ?";

    $databaseConnection = Connect();
    $deleteStatement = $databaseConnection->prepare($deleteSql);

    $deleteStatement->bind_param("i", $studentId);
    $noErrorOccurred = $deleteStatement->execute();

    if($noErrorOccurred) {
        http_response_code(200);
    } else {
        echo json_encode([ "error" => "Failed to delete student data" ]);
        http_response_code(500);
    }
?>