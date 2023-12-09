<?php 
    session_start();
    if(isset($_SESSION["usuario"])){
        include("../classes/MySQL.php");
        include("../classes/Usuario.php");

        $usuario = new Usuario($_SESSION["usuario"]);    

        $sql = new MySQL;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalize seu perfil!</title>

    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/cadastro_producoes.css">
</head>
<body>
<header>
            <div class="header">
                <h2><a href="feed.php">ReelFriends</a></h2>
                <a href="pagina-usuario.php?user=<?php echo $usuario->getId() ?>" class="perfil">
                    <?php
                    echo "<span>" . $usuario->getNome() . "</span>";
                    ?>
                    <img class='foto-perfil' src='<?php $usuario->getPerfil() ?>' alt='".<?php $usuario->getNome() ?>."'>
                </a>
            </div>
        </header>

        <div class="box-container">
            <div class="side-bar-box">
            <menu class="sidebar">
            <form class="search-area" method="post" class="pesquisa-container">
            <input id="search-area" type="text" name="pesquisa" id="pesquisa" placeholder="Digitar...">
            <button type="submit" name="pesquisar">Pesquisar</button>
        </form>

        <?php 
            if(isset($_POST["pesquisar"])){
                header("Location: feed.php?query=".$_POST["pesquisa"]);
            }
        ?>
                <p class="categories">Categorias</p>
                <a href="">Filmes</a>
                <a href="">Séries</a>
            </menu>
            </div>

        
    <main>
        <form action="" method="post">
            <fieldset>
                <h2>Personalizar Perfil</h2>
        </form>


        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <p for="perfil">Selecione sua nova foto de perfil</p>
                <br>
                <input type="file" name="perfil" id="perfil" required>

                <button name="alterarPerfil">Alterar Foto de Perfil</button>
            </fieldset>
        </form>

        <?php 
            if(isset($_POST["alterarPerfil"])){

                $file = $_FILES['perfil'];

                $arquivo = explode(".", $file["name"]);

                //verifica se o arquivo do upload é do tipo png ou jpg
                if(strtolower($arquivo[sizeof($arquivo)-1]) != "png" && strtolower($arquivo[sizeof($arquivo)-1]) != "jpg"){
                    die("Você não pode fazer upload desse tipo de arquivo");
                } else {
                    $dir = "../img/usuario/perfil/";

                    move_uploaded_file($file["tmp_name"], "$dir/".$usuario->getNome()."-".$usuario->getId().".png"); //salva e renomeia o arquivo do upload

                    header("Location: personalizar-perfil.php");
                }
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <label for="banner">Selecione sua nova foto de Capa</label>
                <input type="file" name="banner" id="banner" required>

                <button name="alterarBanner">Alterar Foto de Capa</button>
            </fieldset>
        </form>

        <?php 
            if(isset($_POST["alterarBanner"])){

                $file = $_FILES['banner'];

                $arquivo = explode(".", $file["name"]);

                //verifica se o arquivo do upload é do tipo png ou jpg
                if(strtolower($arquivo[sizeof($arquivo)-1]) != "png" && strtolower($arquivo[sizeof($arquivo)-1]) != "jpg"){
                    die("Você não pode fazer upload desse tipo de arquivo");
                } else {
                    $dir = "../img/usuario/banner/";

                    move_uploaded_file($file["tmp_name"], "$dir/".$usuario->getNome()."-".$usuario->getId().".png"); //salva e renomeia o arquivo do upload

                    header("Location: personalizar-perfil.php");
                }
            }
        ?>
    </main>

    
<?php 
} else {
    header("Location: index.php");
}
?>
</body>
</html>