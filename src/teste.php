<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testes</title>
</head>
<body>
    
</body>
</html>
<?php 
    include("../classes/Usuario.php");

    $usuario = new Usuario("teste@teste.com");

    $usuario->getPerfil();
?>