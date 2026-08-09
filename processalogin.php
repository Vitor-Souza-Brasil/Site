<?php

session_start();

$login = trim($_POST['login']);
$senha = md5($_POST['senha']);

$arquivo = "logins/$login.dat";

if (file_exists($arquivo)) {

    $dados = file($arquivo);

    $senhasalva = trim(
        str_replace("Senha: ", "", $dados[1])
    );

    if ($senha == $senhasalva) {

        $_SESSION['usuario'] = $login;

        header("Location: index.php");
        exit;

    }

}

header("Location: login.php");
exit;

?>