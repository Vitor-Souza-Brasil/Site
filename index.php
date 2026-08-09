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
                    <a href="login.php" class="login-link">Efetuar Login</a>
                    <a href="cadastro1.php" class="cadastro-link">Cadastre-se</a>
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

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box.png">
                </div>
                <h3>Poké Pack Básico</h3>
                <span class="preco">R$ 19,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Poké Pack Básico', 'R$ 19,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box2.png">
                </div>
                <h3>Charizard Holo Raro</h3>
                <span class="preco">R$ 89,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Charizard Holo Raro', 'R$ 89,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box3.png">
                </div>
                <h3>Gengar Sombrio</h3>
                <span class="preco">R$ 49,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Gengar Sombrio', 'R$ 49,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

        </div>

    </div>

    <div class="bloco">

        <div class="titulo-area">
            <div class="linha"></div>
            <h2>Produtos</h2>
            <div class="linha"></div>
        </div>

        <div class="produtos-container">

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box.png">
                </div>
                <h3>Pikachu Elétrico</h3>
                <span class="preco">R$ 24,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Pikachu Elétrico', 'R$ 24,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box2.png">
                </div>
                <h3>Charizard Flame Edition</h3>
                <span class="preco">R$ 99,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Charizard Flame Edition', 'R$ 99,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box3.png">
                </div>
                <h3>Gengar Shadow Rare</h3>
                <span class="preco">R$ 59,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Gengar Shadow Rare', 'R$ 59,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box4.png">
                </div>
                <h3>Bulbasaur Starter Pack</h3>
                <span class="preco">R$ 29,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Bulbasaur Starter Pack', 'R$ 29,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

            <div class="produto-card">
                <div class="imagem-produto">
                    <img src="img/box5.png">
                </div>
                <h3>Squirtle Aqua Edition</h3>
                <span class="preco">R$ 34,90</span>
                <button class="botao-comprar">Comprar</button>
                <button class="botao-carrinho" onclick="adicionarCarrinho('Squirtle Aqua Edition', 'R$ 34,90')">
                    Adicionar ao Carrinho
                </button>
            </div>

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

        <div id="itens-carrinho">
            <p class="vazio">Seu carrinho está vazio.</p>
        </div>

    </div>

</div>

<script>
let carrinho = [];

function adicionarCarrinho(nome, preco) {
    const valor = parseFloat(preco.replace("R$", "").replace(",", "."));

    carrinho.push({ nome, preco, valor });
    atualizarCarrinho();
}

function atualizarCarrinho() {
    const itens = document.getElementById("itens-carrinho");
    const contador = document.getElementById("contador-carrinho");

    contador.innerText = carrinho.length;

    if (carrinho.length === 0) {
        itens.innerHTML = `<p class="vazio">Seu carrinho está vazio.</p>`;
        return;
    }

    let total = 0;
    itens.innerHTML = "";

    carrinho.forEach((item, index) => {
        total += item.valor;

        const div = document.createElement("div");
        div.classList.add("item-carrinho");

        div.innerHTML = `
            <p><strong>${item.nome}</strong></p>
            <p>${item.preco}</p>
            <button onclick="removerItem(${index})"
                style="margin-top:10px;padding:8px;border:none;background:red;color:white;border-radius:8px;cursor:pointer;">
                Remover
            </button>
        `;

        itens.appendChild(div);
    });

    const totalDiv = document.createElement("div");
    totalDiv.style.marginTop = "15px";
    totalDiv.style.padding = "15px";
    totalDiv.style.background = "#111827";
    totalDiv.style.color = "white";
    totalDiv.style.borderRadius = "12px";
    totalDiv.style.fontWeight = "bold";

    totalDiv.innerText = "Total: R$ " + total.toFixed(2).replace(".", ",");

    itens.appendChild(totalDiv);
}

function removerItem(index) {
    carrinho.splice(index, 1);
    atualizarCarrinho();
}

function abrirCarrinho() {
    document.getElementById("fundo-carrinho").style.display = "flex";
}

function fecharCarrinho() {
    document.getElementById("fundo-carrinho").style.display = "none";
}
</script>

</body>
</html>