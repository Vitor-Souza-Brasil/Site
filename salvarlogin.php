<?php

$login = trim($_POST['login']);
$senha = md5(trim($_POST['senha']));

if (!is_dir("logins")) {

    mkdir("logins");

}

$arquivo = "logins/$login.dat";

$dados  = "Login: $login\n";
$dados .= "Senha: $senha";

file_put_contents($arquivo, $dados);

header("Location: login.php");
exit;

?>