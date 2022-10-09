<?php

    session_start();

    if(isset($_SESSION["user"])) {
        http_response_code(200);

    } else {
        http_response_code(401);
        header("Content-Type: application/json");
        echo json_encode([ "error" => "Could not logout" ]);
    }

    session_unset();
    session_destroy();

?>