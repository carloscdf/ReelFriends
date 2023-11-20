<?php 
    include("../classes/MySQL.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça Login!</title>

    <link rel="stylesheet" href="../style/index.css">
</head>
<body>
    <h1>ReelFriends</h1>

    <form action="" method="post">
        <fieldset>
            <h2>Login</h2>
       
            <input type="email" name="email" id="email" placeholder="Digite seu email..." required>

            <input type="password" name="senha" id="senha" placeholder="Digite sua senha..." required>

            <button type="submit" name="enviar">Entrar</button>

            <p>Não possui uma conta? Clique <a href="cadastro_usuarios.php">aqui</a>!</p>
        </fieldset>
    </form>

    <?php 
        if(isset($_POST["enviar"])){
            $sql = new MySQL;

            $rows = $sql->pesquisaEmailUsuario($_POST["email"]); //pesquisa o email inserido

            if($rows != null){
                $senha = hash("sha512", md5($_POST["senha"]));

                if($rows["senha_usuario"]==$senha){
                    $_SESSION["usuario"] = $rows["email_usuario"]; //salva o email do usuario na session

                    header("Location: feed.php");

                } else {
                    echo "[ERRO] Senha incorreta";
                }

            } else {
                echo "[ERRO] O e-mail não está cadastrado no sistema";
            }
        }
    ?>
</body>
</html>