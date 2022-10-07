<?php
require_once("../database/connect.php");

$databaseConnection = connect();

$selectSql = "SELECT * FROM usuario;";

$result = $databaseConnection->query($selectSql);


if ($result) {
    http_response_code(200);

    while($fetch = fetch_assoc($result)) {

        foreach($fetch as $key => $value) {
            $userData[$key] = $value;
        }
    }

    $json = json_encode($userData);

    echo $json;

} else {
    http_response_code(500);
}
