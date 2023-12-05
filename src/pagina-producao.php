<?php //inicializa todas as classes necessárias para a página 
session_start();
if(isset($_SESSION["usuario"])){

    include("../classes/MySQL.php");
    include("../classes/Usuario.php");
    include("../classes/Producao.php");
    
    $usuario = new Usuario($_SESSION["usuario"]);    

    $sql = new MySQL;

    $rows = $sql->pesquisaIdProducao($_GET["prod"]);

    $producao = new Producao($rows["titulo_producao"], $rows["sinopse_producao"], $rows["data_formatada"], $rows["genero_idgenero"], $rows["categoria_idcategoria"], $rows["diretor_iddiretor"]);
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
        <h2><a href="feed.php">ReelFriends</a></h2>

        <div class="pesquisa-container">
            <input type="text" name="pesquisa" id="pesquisa">
        </div>

        <a href="pagina-usuario.php?user=<?php echo $usuario->getId()?>" class="perfil">
            <?php
                echo "<span>".$usuario->getNome()."</span>";
            ?>
            <img class = 'foto-perfil' src='<?php $usuario->getPerfil()?>' alt='".<?php $usuario->getNome()?>."'>
        </a>
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
                        <form action="" method="post">
                        <?php
                            if($sql->verificaFavorito($usuario->getId(), $_GET["prod"])){
                                echo '<button name="favoritar">Favoritar</button>';
                            }
                            else{
                                echo '<button name="desfavoritar">Remover dos favoritos</button>';
                            }
                        ?>
                            
                        </form>
                        
                        <?php 
                            if(isset($_POST["favoritar"])){
                                $sql->cadastraFavorito($usuario->getId(), $_GET["prod"]);
                            }

                            if(isset($_POST["desfavoritar"])){
                                $sql->apagarFavorito($usuario->getId(), $_GET["prod"]);
                            }
                        ?>
                    </div>

                    <div class="avaliacao">
                        <h3>Nota média: <?php echo $producao->getNotaMedia()?></h3>

                        <p>Numero de avaliações: <?php echo $sql->pesquisaNumeroAvaliacoes($_GET["prod"])?></p>

                        <?php 
                            if($sql->verificaAvaliacao($_SESSION["usuario"], $_GET["prod"])){
                                echo "<p>Sua avaliação: ".$sql->pesquisaAvaliacaoUsuario($_SESSION["usuario"], $_GET["prod"])."</p>";
                            }
                        ?>

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

                                <button name="enviar">Enviar avaliação</button>
                            </div>
                        </form>

                        <?php 
                            if(isset($_POST["enviar"])){
                                if(!empty($_POST["estrela"])){

                                    if($sql->verificaAvaliacao($_SESSION["usuario"], $_GET["prod"])){
                                        $sql->atualizaAvaliacao($_SESSION["usuario"], $_GET["prod"], $_POST["estrela"]);
                                        header("Location: pagina-producao.php?prod=".$_GET["prod"]);
                                    }
                                    else{
                                        $sql->cadastraAvaliacao($_SESSION["usuario"], $_GET["prod"], $_POST["estrela"]);
                                        header("Location: pagina-producao.php?prod=".$_GET["prod"]);
                                    }
                                } else {
                                    echo "Escolha ao menos uma estrela!";
                                }
                            }
                        ?>
                    </div>
                    <div class="comentarios">
                        <form class="form-comentario" action="" method="post">
                            <h3>Comentários</h3>
                            <img class = 'foto-perfil' src='<?php $usuario->getPerfil()?>' alt='".<?php $usuario->getNome()?>."'>
                            <textarea name="comentario" id="sinopse" cols="51" rows="5" placeholder="Digite um comentário..." required></textarea>
                            <button type="submit" name="comentar">Enviar</button>
                        </form>

                        <?php 
                            if(isset($_POST["comentar"])){
                                $sql->cadastraComentario($_SESSION["usuario"], $_GET["prod"], $_POST["comentario"]);
                            }
                        ?>

                        <?php 
                            $rows = $sql->pesquisaComentarios($_GET["prod"]);
                            
                            echo "<pre>";
                            echo "</pre>";

                            if($rows != null){
                                foreach($rows as $comentarios){
                                    $email = $sql->pesquisaIdUsuario($comentarios["usuario_idusuario"])["email_usuario"];
                                    $usuarioComentario = new Usuario($email);
                                    ?>
                                    <div class="comentario">
                                        <a href="pagina-usuario.php?user=<?php echo $usuarioComentario->getId()?>" class="perfil-comentario">
                                            <span class="username-comentario"><?php echo $usuarioComentario->getNome()?></span>
                                            <img class = 'foto-perfil' src='<?php $usuarioComentario->getPerfil()?>' alt='".<?php $usuario->getNome()?>."'>
        
                                        </a>

                                        <p><?php echo $comentarios["conteudo_comentario"]?></p>
                                    <?php 
                                        if($usuarioComentario->getEmail() == $_SESSION["usuario"]){
                                            echo '<a class="apagar-comentario" href="pagina-producao.php?prod='.$_GET["prod"].'&del='.$comentarios["idcomentario"].'"><i class="fa-solid fa-trash-can"></i></a>';

                                            if(isset($_GET["del"])){
                                                if($comentarios["idcomentario"] == $_GET["del"]){
                                                    echo "Tem certeza que deseja apagar este comentário para sempre?";
                                                    echo "<a href='apagar-comentario.php?id=".$comentarios["idcomentario"]."&prod=".$_GET["prod"]."'>Sim</a>";
                                                    echo "<a href='pagina-producao.php?prod=".$_GET["prod"]."'>Não</a>";
                                                }
                                            }
                                        }
                                    ?>
                                    </div>
                                <?php 
                                }
                            }
                            else{
                                if($producao->getCategoria() == "Filme"){
                                    echo "<p>Esse filme ainda não possui comentários...</p>";
                                    echo "<p>Seja o primeiro a comentar!</p>";
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