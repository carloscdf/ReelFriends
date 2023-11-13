<?php 
    session_start();
    include("../classes/Usuario.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Os filmes e séries mais recomendados para você</title>

    <link rel="stylesheet" href="../style/feed.css">
</head>
<body>
    <nav>
        <h2>ReelFriends</h2>

        <div class="pesquisa-container">
            <input type="text" name="pesquisa" id="pesquisa">
        </div>

        <div class="perfil">
            <?php
                $usuario = new Usuario($_SESSION["usuario"]);
                echo "<span>".$usuario->getNome()."</span>";
                $usuario->getPerfil();
            ?>

        </div>
    </nav>
    <main>
        <menu>
            <ul>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
                <li><a href="">item</a></li>
            </ul>
        </menu>

        <section>
            <?php 
                $sql = new MySQL;

                $rows = $sql->pesquisaObras();

                if($rows == null){
                    echo "<h1>Ops...    :(</h1>";
                    echo "<p>Parece que não há nenhuma produção cadastrada na plataforma. Clique no botão + para adicionar algum você mesmo</p>";
                }
            ?>
            <a href="cadastro_producoes.php">+</a>

        </section>
    </main>
    
</body>
</html>