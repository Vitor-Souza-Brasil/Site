<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/t.css">
<title>Login</title>
</head>

<body class="tela">

<form class="form" action="processalogin.php" method="POST">

    <h1>Login</h1>

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