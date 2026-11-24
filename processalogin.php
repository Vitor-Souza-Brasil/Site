<?php

include "app/db.php";
include "app/produtos.php";
require_once "app/carrinho_db.php";

session_start();

$login = $_POST['login'] ?? '';
$senha = md5($_POST['senha'] ?? '');

$c = conectar();

$st = $c->prepare("SELECT senha, email, verificado FROM loginn WHERE login = ?");
$st->bind_param("s", $login);
$st->execute();
$linha = $st->get_result()->fetch_assoc();
$st->close();

// usuário não existe ou senha errada
if (!$linha || !hash_equals($linha['senha'], $senha)) {
    $c->close();
    header("Location: login.php?erro=1");
    exit;
}

// e-mail ainda não confirmado -> vai para a tela do código
if ($linha['verificado'] != 1) {
    $c->close();
    header("Location: validar.php?email=" . urlencode((string) $linha['email']));
    exit;
}

session_regenerate_id(true);
$_SESSION['usuario'] = $login;

// é o ADM? (e-mail igual ao $admin_email do cons.php)
if ($linha['email'] && strtolower($linha['email']) === strtolower($admin_email)) {
    $_SESSION['admin'] = true;
}

// traz o carrinho salvo no banco e guarda o carrinho atualizado
carrinho_carregar($c, $login, $produtos);
carrinho_salvar($c, $login, $_SESSION['carrinho']);
$c->close();

header("Location: index.php");
exit;

?>
