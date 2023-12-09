<?php 
    session_start();
    if(isset($_SESSION["usuario"])){
        include("../classes/MySQL.php");
?>
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

            <label for="diretores">Selecione o diretor da produção</label>
            <select name="diretores" id="diretores">
                <?php // cria uma opção do o select para cada diretor
                    $sql = new MySQL;
                    $rows = $sql->pesquisaDiretores();
                    foreach($rows as $diretor){
                        echo "<option value='".$diretor["iddiretor"]."'>".$diretor["nome_diretor"]."</option>";
                    }
                ?>
            </select>

            <br>
            <br>

            <span>O diretor da obra não está cadastrado? Cadastre-o <a href="cadastro_diretores.php">aqui</a></span>

            <textarea name="sinopse" id="sinopse" cols="30" rows="10" placeholder="Digite a sinopse da produção" required></textarea>

            <label for="dtlancamento">Insira a data de lançamento da Produção</label>
            <input type="date" name="dtlancamento" id="dtlancamento">

            <label for="categoria">Selecione a categoria da produção</label>
            <select name="categoria" id="categoria">
                <?php // cria uma opção do o select para cada categoria
                    $rows = $sql->pesquisaCategorias();
                    foreach($rows as $categoria){
                        echo "<option value='".$categoria["idcategoria"]."'>".$categoria["descricao_categoria"]."</option>";
                    }
                ?>
            </select>

            <br>
            <br>

            <label for="genero">Selecione o gênero da produção</label>
            <select name="genero" id="genero">
                <?php // cria uma opção do o select para cada gênero
                    $rows = $sql->pesquisaGeneros();
                    foreach($rows as $genero){
                        echo "<option value='".$genero["idgenero"]."'>".$genero["descricao_genero"]."</option>";
                    }
                ?>
            </select>

            <br>
            <br>

            <label for="capa">Insira a imagem capa da produção</label>
            <input type="file" name="capa" id="capa" required>

            <button type="submit" name="enviar">Enviar</button>
        </fieldset>
    </form>

    <?php 
        if(isset($_POST["enviar"])){

            if($sql->verificaProducao($_POST["titulo"], $_POST["diretores"])){

                $file = $_FILES['capa'];

                $arquivo = explode(".", $file["name"]);

                //verifica se o arquivo do upload é do tipo png ou jpg
                if(strtolower($arquivo[sizeof($arquivo)-1]) != "png" && strtolower($arquivo[sizeof($arquivo)-1]) != "jpg"){
                    die("Você não pode fazer upload desse tipo de arquivo");
                } else {
                    $dir = "../img/producao/capa/";

                    move_uploaded_file($file["tmp_name"], "$dir/".$_POST["titulo"]."-".$_POST["diretores"].".png"); //salva e renomeia o arquivo do upload

                    $sql->cadastraProducao($_POST["titulo"], $_POST["sinopse"], $_POST["dtlancamento"], $_POST["genero"], $_POST["categoria"], $_POST["diretores"]); //cadastra o filme ou série no banco de dados
                }

            } else {
                $rows = $sql->pesquisaIdDiretor($_POST["diretores"]);

                if($_POST["categoria"] == 1){
                    echo "O filme ".$_POST["titulo"]." do diretor ".$rows." já está cadastrado";
                } else {
                    echo "A série ".$_POST["titulo"]." do diretor ".$rows." já está cadastrado";
                }
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