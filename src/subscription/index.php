<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $searchSql = "SELECT jogador_modalidade.*, 
                            jogador.id_turma AS turma_jogador, 
                            jogador.nome, 
                            jogador.matricula,
                            jogador.data_nascimento, 
                            modalidade.id_modalidade,
                            modalidade.nome AS nome_modalidade,
                            turma.curso,
                            turma.ano
                    FROM jogador_modalidade
                    INNER JOIN jogador ON jogador_modalidade.id_jogador = jogador.id_jogador
                    INNER JOIN modalidade ON jogador_modalidade.id_modalidade = modalidade.id_modalidade
                    INNER JOIN turma ON turma.id_turma = jogador_modalidade.id_turma";

    $databaseConnection = Connect();

    $searchResult = $databaseConnection->query($searchSql);

    $subscriptions = [];
    while($subscriptionData = $searchResult->fetch_assoc()) {
        $subscriptions[] = [
            "id" => (int) $subscriptionData["id"],
            "student" =>  [
                "id" => (int) $subscriptionData["id_jogador"],
                "name" => $subscriptionData["nome"],
                "registration" => $subscriptionData["matricula"],
                "birthdate" => $subscriptionData["data_nascimento"],
                "class" => $subscriptionData["turma_jogador"]
            ],
            "sport" => [
                "id" => (int) $subscriptionData["id_modalidade"],
                "name" => $subscriptionData["nome_modalidade"]
            ],
            "class" => [
                "id" => $subscriptionData["id_turma"],
                "course" => $subscriptionData["curso"],
                "year" => (int) $subscriptionData["ano"]
            ]
        ];
    }

    header("Content-Type: application/json");
    echo json_encode([ "subscriptions" => $subscriptions ]);
?>