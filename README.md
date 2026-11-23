# Site Pokéstore

## Descrição do projeto

A Pokéstore é uma loja virtual de cartas e boxes de Pokémon. A ideia do projeto foi criar um site de vendas completo, onde a pessoa consegue ver os produtos, montar o carrinho, criar uma conta e finalizar a compra. O site também tem uma área para o administrador cadastrar produtos novos e avisar os clientes por e-mail.

Foi feito com PHP e MySQL, como projeto de estudo.

## Funcionalidades

- Vitrine com produtos em destaque
- Carrinho de compras (adicionar, remover e alterar quantidade)
- Cadastro de usuário com confirmação por e-mail
- Login e recuperação de senha
- Finalização de compra com escolha da forma de pagamento
- Área do administrador para cadastrar produtos e enviar e-mails aos clientes

## Testes realizados

- Teste de funcionamento: passamos pelo site inteiro, do cadastro até a compra, para ver se tudo funcionava.
- Teste de segurança: conferimos o login, a confirmação de e-mail e o envio de imagens no painel do administrador.
- Teste de erros: tentamos preencher formulários errados e vazios para corrigir os problemas que apareceram.

## Tecnologias e linguagens

- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Bibliotecas

- PHPMailer, para enviar os e-mails

## Pré-requisitos e instalação

Para rodar o projeto é preciso ter o XAMPP (Apache e MySQL) instalado.

1. Copie a pasta do projeto para dentro do `htdocs` do XAMPP.
2. Abra o phpMyAdmin, crie o banco `pokestore` e importe as tabelas.
3. Se quiser enviar e-mails de verdade, instale o PHPMailer com o Composer.

## Instruções de uso

Com o Apache e o MySQL ligados, é só abrir o endereço `http://localhost/` no navegador e procurar a pasta do projeto. Qualquer pessoa pode navegar e montar o carrinho. Para finalizar a compra com conta, basta se cadastrar e confirmar o e-mail.

## Licença

Projeto criado para fins educacionais, sem uso comercial.

## Contribuidores

- Nahan França Viana
- Vitor de Souza Brasil
