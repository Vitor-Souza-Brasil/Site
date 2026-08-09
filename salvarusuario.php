<?php

echo "<pre>";
print_r($_POST);
exit;

$nome = trim($_POST['nome']);
$cpf = trim($_POST['cpf']);
$bairro = trim($_POST['bairro']);
$end = trim($_POST['end']);
$cid = trim($_POST['cid']);
$est = trim($_POST['est']);
$CEP = trim($_POST['CEP']);
$tel = trim($_POST['tel']);

if (!is_dir("usuarios")) {

    mkdir("usuarios");

}

$arquivo = "usuarios/$cpf.dat";

$dados  = "Nome: $nome\n";
$dados .= "CPF: $cpf\n";
$dados .= "Bairro: $bairro\n";
$dados .= "Endereco: $end\n";
$dados .= "Cidade: $cid\n";
$dados .= "Estado: $est\n";
$dados .= "CEP: $CEP\n";
$dados .= "Telefone: $tel\n";

file_put_contents($arquivo, $dados);

header("Location: cadastro2.php");
exit;

?>