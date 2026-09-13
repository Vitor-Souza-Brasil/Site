<?php

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);

$senha = md5($senha);

if (!is_dir("logins")) {

    mkdir("logins");

}

$consulta = "INSERT INTO loginn (Id, senha, login) VALUES (NULL, '$senha', '$login')";
banco($server, $user, $password, $db, $consulta);

header("Location: login.php");
exit;

?>