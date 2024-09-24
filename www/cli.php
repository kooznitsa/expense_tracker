<?php

require __DIR__ . "/vendor/autoload.php";

use Framework\Database;
use Dotenv\Dotenv;
use App\Config\Paths;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$db = new Database(
    $_ENV["MYSQL_DRIVER"],
    [
        "host" => $_ENV["MYSQL_HOST"],
        "port" => $_ENV["HOST_MACHINE_MYSQL_PORT"],
        "dbname" => $_ENV["MYSQL_DATABASE"],
    ],
    $_ENV["MYSQL_USER"],
    $_ENV["MYSQL_PASSWORD"],
);

$sqlFile = file_get_contents("./database.sql");

$db->query($sqlFile);
