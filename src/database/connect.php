<?php

    require_once(__DIR__ . "/../../vendor/autoload.php");

    $envFileDir = __DIR__ . "/./../../";

    Dotenv\Dotenv::createImmutable($envFileDir)->load();

    function Connect() {
        return new mysqli($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"], $_ENV["DB_PORT"]);
    }

?>