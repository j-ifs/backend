<?php
    require_once("../auth/Filter.php");
    require_once("../database/connect.php");

    Filter\AuthenticatedOnly();

    $subscriptionId = substr($_SERVER["PATH_INFO"], 1);

    $searchSql = "SELECT jogador_modalidade.*, 
                    jogador.id_turma, 
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
                INNER JOIN turma ON turma.id_turma = jogador_modalidade.id_turma
                WHERE jogador_modalidade.id = ?";

    $databaseConnection = Connect();

    $searchStatement = $databaseConnection->prepare($searchSql);
    
    $searchStatement->bind_param("i", $subscriptionId);
    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $responseBody = [];
    if($searchResult->num_rows) {
        $subscriptionData = $searchResult->fetch_assoc();

        $responseBody["subscription"] = [
            "id" => (int) $subscriptionData["id"],
            "student" =>  [
                "id" => (int) $subscriptionData["id_jogador"],
                "name" => $subscriptionData["nome"],
                "registration" => $subscriptionData["matricula"],
                "birthdate" => $subscriptionData["data_nascimento"],
                "class" => $subscriptionData["id_turma"]
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

    } else {
        $responseBody["error"] = "Subscription not found";
        http_response_code(404);
    }

    echo json_encode($responseBody);
?>