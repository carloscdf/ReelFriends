<?php 
    session_start();
    if(isset($_SESSION["usuario"])){
        include("../classes/MySQL.php");

        $sql = new MySQL;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre uma novo diretor</title>

    <link rel="stylesheet" href="../style/cadastro_producoes.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<header>
            <div class="header">
            <h2><a href="feed.php">ReelFriends</a></h2>
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

    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <h2>Cadastro Diretor</h2>
        
            <p>Nome</p>
            <input type="text" name="nome" id="nome" placeholder="Digite nome do diretor..." required>

            <label>Biografia</label>
            <textarea name="biografia" id="biografia" cols="30" rows="10" placeholder="Insira uma pequena biografia para o diretor" required></textarea>

            <label for="foto">Insira a foto do perfil do diretor</label>
            <input type="file" name="foto" id="foto" required>

            <button type="submit" name="enviar">Enviar</button>
        </fieldset>
    </form>

    <?php 
        if(isset($_POST["enviar"])){

            if($sql->verificaDiretor($_POST["nome"])){

                $file = $_FILES['foto'];

                $arquivo = explode(".", $file["name"]);

                //verifica se o arquivo do upload é do tipo png ou jpg
                if(strtolower($arquivo[sizeof($arquivo)-1]) != "png" && strtolower($arquivo[sizeof($arquivo)-1]) != "jpg"){
                    die("Você não pode fazer upload desse tipo de arquivo");
                } else {
                    $dir = "../img/diretor_perfil/";

                    move_uploaded_file($file["tmp_name"], "$dir/".$_POST["nome"].".png"); //salva e renomeia o arquivo do upload

                    $sql->cadastraDiretor($_POST["nome"], $_POST["biografia"]); //cadastra o diretor no banco de dados
                }

            } else {
                echo "O diretor ".$_POST["nome"]." já está cadastrado na plataforma";
            }
        }
    ?>
<?php 
} else {
    header("Location: index.php");
}
?></main>
</body>
</html>