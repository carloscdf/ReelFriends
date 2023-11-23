<?php //inicializa todas as classes necessárias para a página 
session_start();
if(isset($_SESSION["usuario"])){

    include("../classes/Usuario.php");
    include("../classes/Producao.php");
    
    $usuario = new Usuario($_SESSION["usuario"]);    

    $sql = new MySQL;

    $rows = $sql->pesquisaIdProducao($_GET["prod"]);

    $producao = new Producao($rows["titulo_producao"], $rows["sinopse_producao"], $rows["dt_lancamento_producao"], $rows["genero_idgenero"], $rows["categoria_idcategoria"], $rows["diretor_iddiretor"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página - <?php echo $producao->getTitulo()?></title>

    <script src="https://kit.fontawesome.com/1a4c71dd0e.js" crossorigin="anonymous"></script>

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
                        <p>Lançado em: <?php echo $producao->getDtLancamento()?></p>
                        <p>Gênero: <?php echo $producao->getGenero()?></p>
                        <p><?php echo $producao->getCategoria()?></p>
                    </div>

                    <div class="avaliacao">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="estrelas">
                                <input type="radio" name="estrela" id="vazio" value="" checked>

                                <label for="estrela_um"><i class="fa fa-star"></i></label>
                                <input type="radio" name="estrela" id="estrela_um" value="1">

                                <label for="estrela_dois"><i class="fa fa-star"></i></label>
                                <input type="radio" name="estrela" id="estrela_dois" value="2">

                                <label for="estrela_tres"><i class="fa fa-star"></i></label>
                                <input type="radio" name="estrela" id="estrela_tres" value="3">

                                <label for="estrela_quatro"><i class="fa fa-star"></i></label>
                                <input type="radio" name="estrela" id="estrela_quatro" value="4">

                                <label for="estrela_cinco"><i class="fa fa-star"></i></label>
                                <input type="radio" name="estrela" id="estrela_cinco" value="5">

                                <button type="submit" name="enviar">Cadastrar avaliação</button>
                            </div>
                        </form>

                        <?php 
                            if(isset($_POST["enviar"])){
                                if(!empty($_POST["estrela"])){
                                    if($sql->verificaAvaliacao($_SESSION["usuario"], $_GET["prod"])){
                                        $sql->cadastraAvaliacao($_SESSION["usuario"], $_GET["prod"], $_POST["estrela"]);
                                    }
                                    else{
                                        echo '"'.$producao->getTitulo().'" já foi avaliado por você';
                                    }
                                } else {
                                    echo "Escolha ao menos uma estrela!";
                                }
                            }
                        ?>
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