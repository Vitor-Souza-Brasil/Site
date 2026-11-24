// Abre e fecha a janela do carrinho (usado pelo index.php)

function abrirCarrinho() {
    document.getElementById("fundo-carrinho").style.display = "flex";
}

function fecharCarrinho() {
    document.getElementById("fundo-carrinho").style.display = "none";
}

// clicar no fundo escuro (fora da caixa branca) também fecha
document.getElementById("fundo-carrinho").addEventListener("click", function (e) {
    if (e.target === this) {
        fecharCarrinho();
    }
});
