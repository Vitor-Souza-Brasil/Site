<?php

include "app/db.php";
require_once "app/codigo.php";

$email = strtolower(trim($_POST['email'] ?? $_GET['email'] ?? ''));
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $codigo = $_POST['codigo'] ?? '';
    $nova = $_POST['senha'] ?? '';

    if (strlen($nova) < 6) {
        $erro = "A senha precisa ter pelo menos 6 caracteres.";
    } else {
        $c = conectar();

        if (conferir_codigo($c, $email, $codigo)) {
            $hash = md5($nova);
            $st = $c->prepare("UPDATE loginn SET senha = ?, codigo = NULL, tentativas = 0 WHERE email = ?");
            $st->bind_param("ss", $hash, $email);
            $st->execute();
            $st->close();
            $c->close();
            header("Location: login.php?senha=1");
            exit;
        }

        $c->close();
        $erro = "Código inválido ou expirado.";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Nova senha</title>
</head>

<body class="tela">

<form class="form" action="redefinir.php" method="POST">

    <h1 style="font-size:28px;">Nova senha</h1>

    <?php if ($erro !== ""): ?>
        <p style="color:#ef4444; margin-bottom:15px; font-size:14px;">
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php elseif (isset($_GET['enviado'])): ?>
        <p style="color:#d1d5db; margin-bottom:20px; font-size:14px;">
            Se o e-mail estiver cadastrado, enviamos um código de recuperação.
        </p>
    <?php endif; ?>

    <div class="inputBox">
        <input type="email" name="email" placeholder=" " value="<?= htmlspecialchars($email) ?>" required>
        <label>E-mail</label>
    </div>

    <div class="inputBox">
        <input type="text" name="codigo" placeholder=" " maxlength="6" inputmode="numeric" required>
        <label>Código de recuperação</label>
    </div>

    <div class="inputBox">
        <input type="password" name="senha" placeholder=" " required>
        <label>Nova senha</label>
    </div>

    <button type="submit">Salvar nova senha</button>

    <p class="registrar">
        <a href="login.php">Voltar ao login</a>
    </p>

</form>

</body>
</html>
