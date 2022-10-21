<?php

    require_once(__DIR__ . "/../../vendor/autoload.php");

    $envFileDir = __DIR__ . "/./../../";

    Dotenv\Dotenv::createImmutable($envFileDir)->load();

    function Connect() {
        $connection = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"], $_ENV["DB_PORT"]);
        $connection->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

        return $connection;
    }

?>