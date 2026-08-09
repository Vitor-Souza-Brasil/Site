<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Login</title>
</head>

<body class="tela">

<form class="form" action="processa_login.php" method="POST">

    <h1>Login</h1>

    <?php if (isset($_GET['erro'])): ?>
        <p style="color:#ef4444; margin-bottom:15px; font-size:14px;">
            Usuário ou senha inválidos
        </p>
    <?php endif; ?>

    <div class="inputBox">
        <input type="text" name="login" placeholder=" " required>
        <label>Usuário</label>
    </div>

    <div class="inputBox">
        <input type="password" name="senha" placeholder=" " required>
        <label>Senha</label>
    </div>

    <button type="submit">Entrar</button>

    <p class="registrar">
        Não tem conta?
        <a href="cadastro1.php">Cadastrar</a>
    </p>

</form>

</body>
</html>