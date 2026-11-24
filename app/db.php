<?php
include_once __DIR__ . "/cons.php";

mysqli_report(MYSQLI_REPORT_OFF);

function conectar($parar = true) {
    global $server, $user, $password, $db;

    $c = new mysqli($server, $user, $password, $db);

    if ($c->connect_error) {
        if ($parar) {
            die("Falha ao conectar no banco.");
        }
        return false;
    }

    $c->set_charset("utf8mb4");
    return $c;
}
