<?php

include "app/db.php";
require_once "app/email.php";
require_once "app/codigo.php";

$email = strtolower(trim($_POST['email'] ?? $_GET['email'] ?? ''));
$msg = "";
$cor = "#ef4444";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $c = conectar();

    if (isset($_POST['reenviar'])) {
        $u = usuario_por_email($c, $email);
        if ($u && $u['verificado'] == 0) {
            $codigo = gerar_codigo($c, $email);
            if ($codigo && enviar_email($email, "Confirme seu e-mail", "Seu novo código de confirmação é: $codigo\n\nEle vale por 15 minutos.")) {
                $msg = "Enviamos um novo código.";
                $cor = "#4ade80";
            } else {
                $msg = "Não foi possível enviar o e-mail. Tente de novo.";
            }
        } else {
            $msg = "E-mail não encontrado ou já confirmado.";
        }

    } elseif (conferir_codigo($c, $email, $_POST['codigo'] ?? '')) {
        $st = $c->prepare("UPDATE loginn SET verificado = 1, codigo = NULL, tentativas = 0 WHERE email = ?");
        $st->bind_param("s", $email);
        $st->execute();
        $st->close();
        $c->close();
        header("Location: login.php?validado=1");
        exit;

    } else {
        $msg = "Código inválido ou expirado.";
    }

    $c->close();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Confirmar e-mail</title>
</head>

<body class="tela">

<form class="form" action="validar.php" method="POST">

    <h1 style="font-size:28px;">Confirmar e-mail</h1>

    <p style="color:#d1d5db; margin-bottom:20px; font-size:14px;">
        Enviamos um código de 6 dígitos para o seu e-mail.
    </p>

    <?php if ($msg !== ""): ?>
        <p style="color:<?= $cor ?>; margin-bottom:15px; font-size:14px;">
            <?= htmlspecialchars($msg) ?>
        </p>
    <?php endif; ?>

    <div class="inputBox">
        <input type="email" name="email" placeholder=" " value="<?= htmlspecialchars($email) ?>" required>
        <label>E-mail</label>
    </div>

    <div class="inputBox">
        <input type="text" name="codigo" placeholder=" " maxlength="6" inputmode="numeric" required>
        <label>Código</label>
    </div>

    <button type="submit">Confirmar</button>

    <button type="submit" name="reenviar" value="1" formnovalidate style="margin-top:12px; background:#374151;">
        Reenviar código
    </button>

    <p class="registrar">
        <a href="login.php">Voltar ao login</a>
    </p>

</form>

</body>
</html>
