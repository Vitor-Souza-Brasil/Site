<?php

function usuario_por_email($c, $email) {
    $st = $c->prepare("SELECT login, verificado FROM loginn WHERE email = ?");
    $st->bind_param("s", $email);
    $st->execute();
    $linha = $st->get_result()->fetch_assoc();
    $st->close();
    return $linha ? $linha : null;
}

function gerar_codigo($c, $email) {
    $codigo = (string) random_int(100000, 999999);

    $st = $c->prepare("UPDATE loginn SET codigo = ?, codigo_expira = DATE_ADD(NOW(), INTERVAL 15 MINUTE), tentativas = 0 WHERE email = ?");
    $st->bind_param("ss", $codigo, $email);
    $st->execute();
    $achou = $st->affected_rows > 0;
    $st->close();

    return $achou ? $codigo : false;
}

function conferir_codigo($c, $email, $digitado) {
    $st = $c->prepare("SELECT codigo, tentativas, (codigo_expira >= NOW()) AS valido FROM loginn WHERE email = ?");
    $st->bind_param("s", $email);
    $st->execute();
    $linha = $st->get_result()->fetch_assoc();
    $st->close();

    if (!$linha || $linha['codigo'] === null || !$linha['valido'] || $linha['tentativas'] >= 5) {
        return false;
    }

    if (hash_equals($linha['codigo'], trim($digitado))) {
        return true;
    }

    $st = $c->prepare("UPDATE loginn SET tentativas = tentativas + 1 WHERE email = ?");
    $st->bind_param("s", $email);
    $st->execute();
    $st->close();
    return false;
}
