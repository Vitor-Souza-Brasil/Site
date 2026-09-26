<?php

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

function formatarPreco(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

?>