<?php
session_start();
if(isset($_SESSION["usuario"])){

    include("../classes/MySQL.php");
    include("../classes/Usuario.php");
    include("../classes/Producao.php");
    
    $usuario = new Usuario($_SESSION["usuario"]);
    
    $sql = new MySQL;

    $usuarioVisitado = new Usuario($sql->pesquisaIdUsuario($_GET["user"])["email_usuario"]);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - <?php echo $usuario->getNome()?></title>

    <link rel="stylesheet" href="../style/pagina-usuario.css">
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
            <div class="perfil-banner">
                <img class = 'foto-banner' src='<?php $usuarioVisitado->getBanner()?>' alt='".$this->username."'>
                <div class="user-info">
                    <div class="user">
                        <img class = 'perfil-usuario' src='<?php $usuarioVisitado->getPerfil()?>' alt='".$this->username."'>
                        <h1><?php echo $usuarioVisitado->getNome()?></h1>
                    </div>
                    
                    <div class="info">
                        <table>
                            <tr>
                                <th>Seguidores</th>
                                <th>Seguindo</th>
                            </tr>
                            <tr>
                                <td><?php echo $sql->pesquisaNumeroSeguidores($usuarioVisitado->getId())?></td>
                                <td><?php echo $sql->pesquisaNumeroSeguimentos($usuarioVisitado->getId())?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="acao">
                            
                        <?php 
                            if($sql->pesquisaIdUsuario($_GET["user"]) == $sql->pesquisaEmailUsuario($_SESSION["usuario"])){
                                echo '<a class="botao-acao" href="personalizar-perfil.php">Personalizar Perfil</a>';
                            }
                            else{?>
                                <form action="" method="post">
                                <?php 
                                    if($sql->verificaSeguidor($usuario->getId(), $_GET["user"])){
                                        echo '<button class="botao-acao" name="follow">Seguir</button>';
                                    }
                                    else{
                                        echo '<button class="botao-acao" name="unfollow">Deixar de Seguir</button>';
                                    }

                                    if(isset($_POST["follow"])){
                                        $sql->cadastraSeguidor($usuario->getId(), $_GET["user"]);
                                    }

                                    if(isset($_POST["unfollow"])){
                                        $sql->apagarSeguimento($usuario->getId(), $_GET["user"]);
                                    }
                                ?>
                                </form>
                          <?php }
                        ?>
                        </div>
                </div>    
            </div>
            
            <h2>Favoritos</h2>
            <div class="favoritos">
                <?php 
                    $rows = $sql->pesquisaFavoritos($usuarioVisitado->getId());

                    if($rows != null){
                        foreach($rows as $favorito){
                            $item = $sql->pesquisaIdProducao($favorito["producao_idproducao"]);
                            
                            $producao = new Producao($item["titulo_producao"], $item["sinopse_producao"],$item["data_formatada"], $item["genero_idgenero"], $item["categoria_idcategoria"], $item["diretor_iddiretor"]);

                            ?>
                            <a class="producao" href="pagina-producao.php?prod=<?php echo $item["idproducao"]?>">
                                <h2><?php echo $producao->getTitulo()?></h2>
                                <img class="imgprod" src="<?php echo $producao->getCapa()?>" alt="<?php echo $producao->getTitulo()?>">

                            </a>
                <?php   }

                    } else {
                        if($sql->pesquisaIdUsuario($_GET["user"]) == $sql->pesquisaEmailUsuario($_SESSION["usuario"])){
                            echo "<p>Você ainda não possui nenhum filme ou série na sua lista de favoritos...</p>";
                        } else {
                            echo "<p>Esse usuário ainda não possui nenhum filme ou série na sua lista de favoritos...</p>";                            
                        }
                    }
                ?>
            </div>
        </section>
    </main>    
<?php 
} else {
    header("Location: index.php");
}
?>
</body>
</html>