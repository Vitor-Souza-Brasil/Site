<?php

include "app/cons.php";
require_once "app/DLL.php";

session_start();

extract($_POST);

$senha = md5($senha);

$sql_verifica = "SELECT * FROM loginn WHERE login = '$login'";
$resultado = banco($server, $user, $password, $db, $sql_verifica);
$linha = $resultado->fetch_assoc();

if($linha == true){
    $senhasalva = $linha['senha'];
    if($senhasalva == $senha){

        $_SESSION['usuario'] = $login;

        header("Location: index.php");
        exit;   

    }

    header("Location: login.php");
    exit;
}

header("Location: login.php");
exit;

?>