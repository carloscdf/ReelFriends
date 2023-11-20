<?php //inicializa todas as classes necessárias para a página 
session_start();
if(isset($_SESSION["usuario"])){

    include("../classes/Usuario.php");
    include("../classes/Producao.php");
    
    $usuario = new Usuario($_SESSION["usuario"]);    

    $sql = new MySQL;

    $rows = $sql->pesquisaIdProducao($_GET["prod"]);

    $producao = new Producao($rows["titulo_producao"], $rows["sinopse_producao"], $rows["genero_idgenero"], $rows["categoria_idcategoria"], $rows["diretor_iddiretor"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página - <?php echo $producao->getTitulo()?></title>

    <link rel="stylesheet" href="../style/pagina-producao.css">
</head>
<body>
    <nav>
        <h2>ReelFriends</h2>

        <div class="pesquisa-container">
            <input type="text" name="pesquisa" id="pesquisa">
        </div>

        <div class="perfil">
            <?php
                echo "<span>".$usuario->getNome()."</span>";
                $usuario->getPerfil();
            ?>

        </div>
    </nav>
    <main>
        <menu>
            <ul>
                <li><a href="">Filmes</a></li>
                <li><a href="">Séries</a></li>
            </ul>
        </menu>

        <section>
            <div class="filme-info">
                <img class="imgprod" src="<?php echo $producao->getCapa()?>" alt="<?php echo $producao->getTitulo()?>">
                <p><?php echo $producao->getSinopse()?></p>
            </div>
            <div class="banner-descricao-avaliacao">
                <img class="bannerprod" src="" alt="">

                <div class="descricao-avaliacao">
                    <div class="descricao">
                        <h1><?php echo $producao->getTitulo()?></h1>
                        <p>Dirigido por: <?php echo $producao->getDiretor()?></p>
                        <p>Genero: <?php echo $producao->getGenero()?></p>
                        <p><?php echo $producao->getCategoria()?></p>
                    </div>

                    <div class="avaliacao">
                        
                    </div>
                </div>
            </div>
            <?php 

            ?>

        </section>
    </main>
<?php 
} else {
    header("Location: index.php");
}
    ?>
</body>
</html>