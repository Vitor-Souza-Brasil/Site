<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro — Parte 2</title>
    <link rel="stylesheet" href="css/t.css">
</head>

<body class="fundocasdois">

<div class="container-cadastrodois" style="height:auto;">

    <h2>Finalizar Cadastro</h2>

    <?php if (isset($_GET['erro'])): ?>
        <p style="color:#ef4444; margin-bottom:15px; font-size:14px; text-align:center;">
            <?= htmlspecialchars($_GET['erro']) ?>
        </p>
    <?php endif; ?>

    <form class="form-cadastro linha" action="salvarlogin.php" method="POST">

    <input name="login" type="text" placeholder="Usuário" required>

    <input name="email" type="email" placeholder="E-mail" required>

    <input name="senha" type="password" placeholder="Senha" required>

    <button type="submit">
        Finalizar Cadastro
    </button>

</form>

</div>

</body>
</html>