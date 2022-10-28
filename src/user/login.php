<?php
    require_once(__DIR__ . "/../database/connect.php");
    // Get post data
    $postData = file_get_contents('php://input');

    // Converts it into a PHP object
    $requestBodyJson = json_decode($postData, true);
    $user = $requestBodyJson["user"]; // Get student data

    $searchSql = "SELECT id_adm, cargo, nome, usuario, senha, IF (id_representante IS NULL, NULL, (
                                SELECT representante.id_turma FROM representante 
                                WHERE representante.id_representante = adm.id_representante
                                LIMIT 0, 1
                            )
                        ) AS id_turma
                    FROM adm
                    WHERE usuario = ? AND senha = ?";

    $databaseConnection = Connect();

    $searchStatement = $databaseConnection->prepare($searchSql);
    $searchStatement->bind_param("ss", $user["username"], $user["password"]);

    $searchStatement->execute();

    $searchResult = $searchStatement->get_result();

    $response = [];
    if($searchResult->num_rows) {
        http_response_code(200);
        session_start();

        $userData = $searchResult->fetch_assoc();
        
        $response["user"] = [
            "id" => $userData["id_adm"],
            "role" => $userData["cargo"],
            "name" => $userData["nome"],
            "username" => $userData["usuario"]
        ];

        if($class = $userData["id_turma"]) {
            $response["user"]["class"] = $class;
        }

        $_SESSION["user"] = $userData["id_adm"];
        $_SESSION["role"] = $userData["cargo"];

    } else {
        http_response_code(401);
        $response["error"] = "Invalid credentials";
    }

    header("Content-Type: application/json");
    echo json_encode($response);
?>