<?php
// Guarda o carrinho no banco (só para quem está logado).
// No banco fica só: usuário, id do produto e quantidade.
// Nome e preço sempre vêm do produtos.php (assim o preço nunca fica desatualizado).

// Salva o carrinho que está na sessão no banco (apaga o antigo e grava o atual).
function carrinho_salvar($c, $usuario, $carrinho) {
    $st = $c->prepare("DELETE FROM carrinho WHERE usuario = ?");
    $st->bind_param("s", $usuario);
    $st->execute();
    $st->close();

    $st = $c->prepare("INSERT INTO carrinho (usuario, produto_id, quantidade) VALUES (?, ?, ?)");
    foreach ($carrinho as $id => $item) {
        $pid = (int) $id;
        $qtd = (int) $item['quantidade'];
        $st->bind_param("sii", $usuario, $pid, $qtd);
        $st->execute();
    }
    $st->close();
}

// Lê o carrinho do banco e junta com o que já está na sessão.
function carrinho_carregar($c, $usuario, $produtos) {
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    $st = $c->prepare("SELECT produto_id, quantidade FROM carrinho WHERE usuario = ?");
    $st->bind_param("s", $usuario);
    $st->execute();
    $res = $st->get_result();

    while ($linha = $res->fetch_assoc()) {
        $id = (int) $linha['produto_id'];

        if (!isset($produtos[$id])) continue; // produto não existe mais

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['quantidade'] += (int) $linha['quantidade'];
        } else {
            $_SESSION['carrinho'][$id] = [
                "nome" => $produtos[$id]['nome'],
                "preco" => $produtos[$id]['preco'],
                "quantidade" => (int) $linha['quantidade'],
            ];
        }
    }
    $st->close();
}
