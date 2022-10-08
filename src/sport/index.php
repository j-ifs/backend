<?php

    require_once("../database/connect.php");

    $searchSql = "SELECT * FROM modalidade";

    $databaseConnection = Connect();
    
    $serachResult = $databaseConnection->query($searchSql);

    $sports = [];
    while($sportData = $serachResult->fetch_assoc()) {
        $sports[] = [
            "id" => $sportData["id_modalidade"],
            "name" => $sportData["nome"]
        ];
    }

    echo json_encode([ "sports" => $sports ]);

?>