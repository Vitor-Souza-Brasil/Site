<?php

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);

if (!is_dir("usuarios")) {

    mkdir("usuarios");

}

$consulta = "INSERT INTO usuario (Id, nome, cpf, bairro, endereco, cidade, estado, cep, telefone) VALUES (NULL, '$nome', '$cpf', '$bairro', '$endereco', '$cidade', '$estado', '$CEP', '$telefone')";
banco($server, $user, $password, $db, $consulta);

header("Location: cadastro2.php");
exit;

?>