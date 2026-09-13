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

        <input name="telefone" type="text" placeholder="Telefone" required>

        <input name="endereco" class="full" type="text" placeholder="Endereço" required>

        <input name="bairro" type="text" placeholder="Bairro" required>

        <input name="CEP" type="text" placeholder="CEP" required>
        
        <input name="cidade" type="text" placeholder="Cidade" required>

        <input name="estado" type="text" placeholder="Estado" required>

    <button type="submit"> Próximo </button>

</form>

</div>

</body>
</html>