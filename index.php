<?php

session_start();
include "app/produtos.php";

if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

function contarItensCarrinho(array $carrinho): int {
    $total = 0;
    foreach ($carrinho as $item) {
        $total += $item['quantidade'];
    }
    return $total;
}

function totalCarrinho(array $carrinho): float {
    $total = 0.0;
    foreach ($carrinho as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }
    return $total;
}

$totalItensCarrinho = contarItensCarrinho($_SESSION['carrinho']);
$totalValorCarrinho = totalCarrinho($_SESSION['carrinho']);

$abrirCarrinhoAutomaticamente = isset($_GET['carrinho']) || isset($_GET['sucesso']) || isset($_GET['erro']);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Minha Loja</title>
    <link rel="stylesheet" href="css/t.css">
</head>

<body>

<div id="corpo">

    <div id="cabecalho">

        <div class="logo">
            <img src="img/logo.png">
        </div>

        <div class="header-direita">

            <div class="login-area">

                <div class="icone-login">
                    👤
                </div>

                <div class="texto-login">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <span class="login-link"><?= htmlspecialchars($_SESSION['usuario']) ?></span>
                        <a href="logout.php" class="cadastro-link">Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="login-link">Efetuar Login</a>
                        <a href="cadastro1.php" class="cadastro-link">Cadastre-se</a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="carrinho-btn" onclick="abrirCarrinho()">
                🛒
                <span id="contador-carrinho">0</span>
            </div>

        </div>

    </div>

    <div class="banner">
        <img src="img/banner.png">
    </div>

    <div class="banner_anuncio">
        EM MAIO CONCORRA A ATÉ 40 SORTEIOS
    </div>

    <div class="bloco">

        <div class="titulo-area">
            <div class="linha"></div>
            <h2>Produtos em Destaque</h2>
            <div class="linha"></div>
        </div>

<div class="produtos-container">
            <?php foreach ($produtos as $id => $produto): ?>
                <?php if ($produto['destaque']): ?>
                    <div class="produto-card">
                        <div class="imagem-produto">
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>">
                        </div>
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <span class="preco"><?= formatarPreco($produto['preco']) ?></span>
                        <form method="POST" action="carrinho.php">
                            <input type="hidden" name="produto_id" value="<?= (int) $id ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <button type="submit" class="botao-carrinho">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>

    <div class="bloco">

        <div class="titulo-area">
            <div class="linha"></div>
            <h2>Produtos</h2>
            <div class="linha"></div>
        </div>

        <div class="produtos-container">
            <?php foreach ($produtos as $id => $produto): ?>
                <?php if (!$produto['destaque']): ?>
                    <div class="produto-card">
                        <div class="imagem-produto">
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>">
                        </div>
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <span class="preco"><?= formatarPreco($produto['preco']) ?></span>
                        <form method="POST" action="carrinho.php">
                            <input type="hidden" name="produto_id" value="<?= (int) $id ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <button type="submit" class="botao-carrinho">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>

    <div id="rodape">
        Todos os direitos reservados © 2026 - Minha Loja
    </div>

</div>

<div id="fundo-carrinho">

    <div id="carrinho-box">

        <div class="topo-carrinho">
            <h2>Seu Carrinho</h2>
            <button onclick="fecharCarrinho()">X</button>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <p style="color:#16a34a; font-weight:bold; margin-bottom:15px;">
                Compra #<?= (int) $_GET['venda_id'] ?> realizada com sucesso!
                Total: <?= formatarPreco((float) ($_GET['total'] ?? 0)) ?>
            </p>
        <?php elseif (isset($_GET['erro'])): ?>
            <p style="color:#ef4444; font-weight:bold; margin-bottom:15px;">
                <?= htmlspecialchars($_GET['erro']) ?>
            </p>
        <?php endif; ?>

        <div id="itens-carrinho">
            <?php if (count($_SESSION['carrinho']) === 0): ?>
                <p class="vazio">Seu carrinho está vazio.</p>
            <?php else: ?>
                <?php foreach ($_SESSION['carrinho'] as $id => $item): ?>
                    <?php $subtotal = $item['preco'] * $item['quantidade']; ?>
                    <div class="item-carrinho">
                        <p><strong><?= htmlspecialchars($item['nome']) ?></strong></p>
                        <p>
                            <?= formatarPreco($item['preco']) ?> x <?= (int) $item['quantidade'] ?>
                            = <?= formatarPreco($subtotal) ?>
                        </p>
                        <div style="display:flex; gap:8px; margin-top:10px; align-items:center;">
                            <form method="POST" action="carrinho.php" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= (int) $id ?>">
                                <input type="hidden" name="acao" value="diminuir">
                                <button type="submit" style="padding:8px 12px;border:none;background:#e5e7eb;border-radius:8px;cursor:pointer;">-</button>
                            </form>
                            <form method="POST" action="carrinho.php" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= (int) $id ?>">
                                <input type="hidden" name="acao" value="aumentar">
                                <button type="submit" style="padding:8px 12px;border:none;background:#e5e7eb;border-radius:8px;cursor:pointer;">+</button>
                            </form>
                            <form method="POST" action="carrinho.php" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= (int) $id ?>">
                                <input type="hidden" name="acao" value="remover">
                                <button type="submit" style="padding:8px;border:none;background:red;color:white;border-radius:8px;cursor:pointer;">Remover</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div style="margin-top:15px; padding:15px; background:#111827; color:white; border-radius:12px; font-weight:bold;">
                    Total: <?= formatarPreco($totalValorCarrinho) ?>
                </div>

                <form method="POST" action="finalizar_compra.php" style="margin-top:20px;">
                    <label for="forma_pagamento" style="display:block; margin-bottom:8px; font-weight:bold;">
                        Forma de pagamento:
                    </label>
                    <select name="forma_pagamento" id="forma_pagamento" required
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #d1d5db; margin-bottom:15px;">
                        <option value="">Selecione...</option>
                        <option value="pix">Pix</option>
                        <option value="cartao_credito">Cartão de Crédito</option>
                        <option value="cartao_debito">Cartão de Débito</option>
                        <option value="boleto">Boleto</option>
                    </select>
                    <button type="submit" class="botao-comprar">Finalizar Compra</button>
                </form>
            <?php endif; ?>
        </div>

    </div>

</div>

<script src="js/carrinho.js"></script>
<?php if ($abrirCarrinhoAutomaticamente): ?>
<script>
    abrirCarrinho();
</script>
<?php endif; ?>

</body>
</html>