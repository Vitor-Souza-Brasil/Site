<?php

include_once __DIR__ . "/cons.php";

$produtos = [
    1 => ["nome" => "Poké Pack Básico",        "preco" => 19.90, "imagem" => "img/box.png",  "destaque" => true],
    2 => ["nome" => "Charizard Holo Raro",     "preco" => 89.90, "imagem" => "img/box2.png", "destaque" => true],
    3 => ["nome" => "Gengar Sombrio",          "preco" => 49.90, "imagem" => "img/box3.png", "destaque" => true],
    4 => ["nome" => "Pikachu Elétrico",        "preco" => 24.90, "imagem" => "img/box.png",  "destaque" => false],
    5 => ["nome" => "Charizard Flame Edition", "preco" => 99.90, "imagem" => "img/box2.png", "destaque" => false],
    6 => ["nome" => "Gengar Shadow Rare",      "preco" => 59.90, "imagem" => "img/box3.png", "destaque" => false],
    7 => ["nome" => "Bulbasaur Starter Pack",  "preco" => 29.90, "imagem" => "img/box4.png", "destaque" => false],
    8 => ["nome" => "Squirtle Aqua Edition",   "preco" => 34.90, "imagem" => "img/box5.png", "destaque" => false],
];

// Produtos cadastrados na página de ADM (vêm do banco).
// Se o banco falhar, o site continua mostrando só os produtos acima.
try {
    $conexao_produtos = @new mysqli($server, $user, $password, $db);
    if (!$conexao_produtos->connect_error) {
        $res_produtos = @$conexao_produtos->query("SELECT Id, nome, preco, imagem, destaque FROM produtos ORDER BY Id");
        if ($res_produtos) {
            while ($linha_produto = $res_produtos->fetch_assoc()) {
                $produtos[(int) $linha_produto['Id']] = [
                    "nome" => $linha_produto['nome'],
                    "preco" => (float) $linha_produto['preco'],
                    "imagem" => $linha_produto['imagem'],
                    "destaque" => (bool) $linha_produto['destaque'],
                ];
            }
        }
        $conexao_produtos->close();
    }
} catch (Throwable $e) {
}

function formatarPreco(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

?>