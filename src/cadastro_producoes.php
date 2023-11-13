<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre uma nova produção</title>

    <link rel="stylesheet" href="../style/cadastro_producoes.css">
</head>
<body>
    <h1>ReelFriends</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <h2>Cadastro Produção</h2>
        
            <input type="text" name="titulo" id="titulo" placeholder="Digite o título da produção..." required>

            <textarea name="sinopse" id="sinopse" cols="30" rows="10" placeholder="Digite a sinopse da produção" required></textarea>

            <label for="capa">Insira a imagem capa da produção</label>
            <input type="file" name="capa" id="capa" required>

            <button type="submit" name="enviar">Enviar</button>
        </fieldset>
    </form>
</body>
</html>