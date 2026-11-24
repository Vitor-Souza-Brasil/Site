<?php

include "app/db.php";
require_once "app/email.php";
require_once "app/codigo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));

    $c = conectar();
    $u = usuario_por_email($c, $email);

    if ($u && $u['verificado'] == 1) {
        $codigo = gerar_codigo($c, $email);
        if ($codigo) {
            enviar_email($email, "Recuperação de senha", "Seu código de recuperação é: $codigo\n\nEle vale por 15 minutos.\nSe não foi você que pediu, ignore este e-mail.");
        }
    }
    $c->close();

    header("Location: redefinir.php?email=" . urlencode($email) . "&enviado=1");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Recuperar senha</title>
</head>

<body class="tela">

<form class="form" action="esqueceu.php" method="POST">

    <h1 style="font-size:28px;">Recuperar senha</h1>

    <p style="color:#d1d5db; margin-bottom:20px; font-size:14px;">
        Digite seu e-mail e enviaremos um código de recuperação.
    </p>

    <div class="inputBox">
        <input type="email" name="email" placeholder=" " required>
        <label>E-mail</label>
    </div>

    <button type="submit">Enviar código</button>

    <p class="registrar">
        <a href="login.php">Voltar ao login</a>
    </p>

</form>

</body>
</html>
