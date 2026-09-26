<?php

session_start();
include "app/produtos.php";

if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

function processarAcaoCarrinho(array $produtos, array $post): void {

    $acao = $post['acao'] ?? null;
    $produto_id = isset($post['produto_id']) ? (int) $post['produto_id'] : null;

    if ($acao === "adicionar" && $produto_id !== null && isset($produtos[$produto_id])) {

        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                "nome" => $produtos[$produto_id]['nome'],
                "preco" => $produtos[$produto_id]['preco'],
                "quantidade" => 1,
            ];
        }
        return;
    }

    if ($acao === "aumentar" && $produto_id !== null && isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id]['quantidade']++;
        return;
    }

    if ($acao === "diminuir" && $produto_id !== null && isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id]['quantidade']--;
        if ($_SESSION['carrinho'][$produto_id]['quantidade'] <= 0) {
            unset($_SESSION['carrinho'][$produto_id]);
        }
        return;
    }

    if ($acao === "remover" && $produto_id !== null) {
        unset($_SESSION['carrinho'][$produto_id]);
        return;
    }

    if ($acao === "esvaziar") {
        $_SESSION['carrinho'] = [];
        return;
    }
}

processarAcaoCarrinho($produtos, $_POST);

header("Location: index.php?carrinho=1");
exit;

?>