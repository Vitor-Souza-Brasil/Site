<?php

include "app/db.php";
require_once "app/email.php";
require_once "app/codigo.php";

$login = trim($_POST['login'] ?? '');
$senha = $_POST['senha'] ?? '';
$email = strtolower(trim($_POST['email'] ?? ''));

function voltar($mensagem) {
    header("Location: cadastro2.php?erro=" . urlencode($mensagem));
    exit;
}

if ($login === '' || $senha === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    voltar("Preencha tudo e use um e-mail válido.");
}

$c = conectar();

$st = $c->prepare("DELETE FROM loginn WHERE (login = ? OR email = ?) AND verificado = 0");
$st->bind_param("ss", $login, $email);
$st->execute();
$st->close();

$st = $c->prepare("SELECT Id FROM loginn WHERE login = ? OR email = ?");
$st->bind_param("ss", $login, $email);
$st->execute();
$existe = $st->get_result()->fetch_assoc();
$st->close();

if ($existe) {
    voltar("Esse usuário ou e-mail já está cadastrado.");
}

$senha = md5($senha);
$st = $c->prepare("INSERT INTO loginn (senha, login, email) VALUES (?, ?, ?)");
$st->bind_param("sss", $senha, $login, $email);
$st->execute();
$st->close();

$codigo = gerar_codigo($c, $email);
if ($codigo) {
    enviar_email($email, "Confirme seu e-mail", "Olá, $login!\n\nSeu código de confirmação é: $codigo\n\nEle vale por 15 minutos.");
}
$c->close();

header("Location: validar.php?email=" . urlencode($email));
exit;

?>
