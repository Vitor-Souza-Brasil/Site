<?php

session_start();

if (empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include "app/db.php";
require_once "app/email.php";

if (isset($_POST['cadastrar_produto'])) {

    $nome = trim($_POST['nome'] ?? '');
    $preco = (float) str_replace(',', '.', $_POST['preco'] ?? '0');
    $destaque = isset($_POST['destaque']) ? 1 : 0;

    $limite = 2 * 1024 * 1024; 
    $tipos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    $aviso = ["erro", "Erro ao cadastrar o produto."];

    if ($nome === '' || $preco <= 0) {
        $aviso = ["erro", "Preencha o nome e um preço válido."];

    } elseif (!isset($_FILES['imagem']) || !is_array($_FILES['imagem'])) {
        $aviso = ["erro", "Arquivo não recebido. Verifique o php.ini."];

    } else {
        $arquivo = $_FILES['imagem'];

        if ($arquivo['error'] === UPLOAD_ERR_NO_FILE) {
            $aviso = ["erro", "Nenhuma imagem foi enviada."];

        } elseif ($arquivo['error'] === UPLOAD_ERR_INI_SIZE || $arquivo['error'] === UPLOAD_ERR_FORM_SIZE) {
            $aviso = ["erro", "A imagem é maior que o limite permitido (2 MB)."];

        } elseif ($arquivo['error'] === UPLOAD_ERR_PARTIAL) {
            $aviso = ["erro", "Upload incompleto. Tente enviar de novo."];

        } elseif ($arquivo['error'] !== UPLOAD_ERR_OK) {
            $aviso = ["erro", "Falha no upload. Código: " . $arquivo['error']];

        } elseif ($arquivo['size'] <= 0 || $arquivo['size'] > $limite) {
            $aviso = ["erro", "A imagem deve ter até 2 MB."];

        } else {
            $info = finfo_open(FILEINFO_MIME_TYPE);

            if ($info === false) {
                $aviso = ["erro", "A verificação do arquivo falhou (extensão fileinfo)."];
            } else {
                $mime = finfo_file($info, $arquivo['tmp_name']);
                finfo_close($info);

                if ($mime === false || !isset($tipos[$mime])) {
                    $aviso = ["erro", "Formato inválido: use JPG, PNG ou WEBP."];

                } else {
                    $pasta = __DIR__ . "/img/produtos/";
                    if (!is_dir($pasta)) {
                        mkdir($pasta, 0755, true);
                    }

                    $nomeNovo = bin2hex(random_bytes(16)) . "." . $tipos[$mime];

                    if (move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeNovo)) {
                        $caminho = "img/produtos/" . $nomeNovo;

                        $c = conectar();
                        $st = $c->prepare("INSERT INTO produtos (nome, preco, imagem, destaque) VALUES (?, ?, ?, ?)");
                        $st->bind_param("sdsi", $nome, $preco, $caminho, $destaque);
                        $ok = $st->execute();
                        $st->close();
                        $c->close();

                        $aviso = $ok ? ["ok", "Produto cadastrado! Já aparece na loja."] : ["erro", "Erro ao salvar o produto no banco."];
                    } else {
                        $aviso = ["erro", "Erro ao mover o arquivo para a pasta img/produtos."];
                    }
                }
            }
        }
    }

    $_SESSION['aviso_produto'] = $aviso;
    header("Location: admin.php");
    exit;
}

if (isset($_POST['enviar_emails'])) {

    set_time_limit(0);

    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($assunto === '' || $mensagem === '') {
        $aviso = ["erro", "Preencha o assunto e a mensagem."];
    } else {
        $c = conectar();
        $res = $c->query("SELECT email FROM loginn WHERE email IS NOT NULL AND email <> '' AND verificado = 1");

        $enviados = 0;
        $falhas = 0;
        while ($linha = $res->fetch_assoc()) {
            if (enviar_email($linha['email'], $assunto, $mensagem)) $enviados++; else $falhas++;
        }
        $c->close();

        $texto = "E-mails enviados: $enviados. Falhas: $falhas.";
        if (email_modo_teste()) $texto .= " (MODO TESTE: nada foi enviado de verdade, veja app/emails.log)";
        $aviso = [$falhas == 0 ? "ok" : "erro", $texto];
    }

    $_SESSION['aviso_email'] = $aviso;
    header("Location: admin.php");
    exit;
}

$aviso_produto = $_SESSION['aviso_produto'] ?? null;
$aviso_email = $_SESSION['aviso_email'] ?? null;
unset($_SESSION['aviso_produto'], $_SESSION['aviso_email']);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Administração</title>
</head>

<body class="fundocas">

<div style="display:flex; flex-direction:column; gap:30px;">

    <div class="container-cadastro">

        <h2>Cadastrar Produto</h2>

        <?php if ($aviso_produto): ?>
            <p style="color:<?= $aviso_produto[0] == 'ok' ? '#4ade80' : '#ef4444' ?>; margin-bottom:15px; text-align:center;">
                <?= htmlspecialchars($aviso_produto[1]) ?>
            </p>
        <?php endif; ?>

        <form class="form-cadastro" method="POST" enctype="multipart/form-data">

            <input name="nome" type="text" placeholder="Nome do produto" required>

            <input name="preco" type="text" placeholder="Preço (ex: 19,90)" required>

            <p style="color:#d1d5db; font-size:13px; margin-top:-6px;">Imagem: JPG, PNG ou WEBP, até 2 MB.</p>

            <input name="imagem" type="file" accept=".jpg,.jpeg,.png,.webp" required style="padding-top:15px;">

            <label style="color:white;">
                <input type="checkbox" name="destaque" style="width:auto; height:auto;">
                Mostrar em "Produtos em Destaque"
            </label>

            <button type="submit" name="cadastrar_produto">Cadastrar Produto</button>

        </form>

    </div>

    <div class="container-cadastro">

        <h2>Mandar E-mails</h2>

        <p style="color:#d1d5db; text-align:center; margin-bottom:20px; font-size:14px;">
            O e-mail vai para todos os clientes que confirmaram o e-mail.
        </p>

        <?php if ($aviso_email): ?>
            <p style="color:<?= $aviso_email[0] == 'ok' ? '#4ade80' : '#ef4444' ?>; margin-bottom:15px; text-align:center;">
                <?= htmlspecialchars($aviso_email[1]) ?>
            </p>
        <?php endif; ?>

        <form class="form-cadastro" method="POST">

            <input name="assunto" type="text" placeholder="Assunto" required>

            <textarea name="mensagem" placeholder="Mensagem" required
                style="width:100%; height:150px; padding:15px; border:none; border-radius:12px; outline:none; font-size:15px; resize:vertical;"></textarea>

            <button type="submit" name="enviar_emails" onclick="return confirm('Enviar para todos os clientes?');">
                Enviar E-mails
            </button>

        </form>

    </div>

    <p style="text-align:center;">
        <a href="index.php" style="color:white;">← Voltar para a loja</a>
    </p>

</div>

</body>
</html>
