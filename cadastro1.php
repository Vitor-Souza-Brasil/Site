<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="css/t.css">
</head>

<body class="fundocas">

<div class="container-cadastro">

<h2>Cadastro</h2>

    <form class="form-cadastro" action="salvarusuario.php" method="POST">

        <input name="nome" class="full" type="text" placeholder="Nome completo" required>

        <input name="cpf" type="text" placeholder="CPF" required>

        <input name="tel" type="text" placeholder="Telefone" required>

        <input name="end" class="full" type="text" placeholder="Endereço" required>

        <input name="bairro" type="text" placeholder="Bairro" required>

        <input name="CEP" type="text" placeholder="CEP" required>
        
        <input name="cid" type="text" placeholder="Cidade" required>
        <input name="est" type="text" placeholder="Estado" required>

    <button type="submit"> Próximo </button>

</form>

</div>

</body>
</html>