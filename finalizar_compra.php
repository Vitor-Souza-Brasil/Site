<?php

session_start();
include "app/cons.php";

const FORMAS_PAGAMENTO_VALIDAS = ["pix", "cartao_credito", "cartao_debito", "boleto"];

function calcularTotalCarrinho(array $carrinho): float {
    $total = 0.0;
    foreach ($carrinho as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }
    return $total;
}

function redirecionarComErro(string $mensagem): void {
    header("Location: index.php?carrinho=1&erro=" . urlencode($mensagem));
    exit;
}

if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    redirecionarComErro("Seu carrinho está vazio.");
}

$formaPagamento = $_POST['forma_pagamento'] ?? '';

if (!in_array($formaPagamento, FORMAS_PAGAMENTO_VALIDAS, true)) {
    redirecionarComErro("Selecione uma forma de pagamento válida.");
}

$usuario = $_SESSION['usuario'] ?? null;

$conexao = new mysqli($server, $user, $password, $db);

if ($conexao->connect_error) {
    redirecionarComErro("Falha de conexão com o banco.");
}

$total = calcularTotalCarrinho($_SESSION['carrinho']);

$stmt = $conexao->prepare("INSERT INTO vendas (usuario, forma_pagamento, total) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $usuario, $formaPagamento, $total);

if (!$stmt->execute()) {
    $stmt->close();
    $conexao->close();
    redirecionarComErro("Erro ao salvar a venda.");
}

$venda_id = $conexao->insert_id;
$stmt->close();

$stmtItem = $conexao->prepare("INSERT INTO itens_venda (venda_id, produto, preco, quantidade) VALUES (?, ?, ?, ?)");

foreach ($_SESSION['carrinho'] as $item) {
    $produto = $item['nome'];
    $preco = $item['preco'];
    $quantidade = $item['quantidade'];
    $stmtItem->bind_param("isdi", $venda_id, $produto, $preco, $quantidade);
    $stmtItem->execute();
}

$stmtItem->close();
$conexao->close();

$_SESSION['carrinho'] = [];

header("Location: index.php?sucesso=1&venda_id=" . (int) $venda_id . "&total=" . urlencode(number_format($total, 2, '.', '')));
exit;

?>