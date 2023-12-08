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
</head>
<body>
    <h1>ReelFriends</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <h2>Cadastro Produção</h2>
        
            <input type="text" name="nome" id="nome" placeholder="Digite nome do diretor..." required>

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
                if($arquivo[sizeof($arquivo)-1] != "png" && $arquivo[sizeof($arquivo)-1] != "jpg"){
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
?>
</body>
</html>