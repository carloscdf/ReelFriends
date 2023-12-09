<?php 
    include("../classes/MySQL.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se!</title>

    <link rel="stylesheet" href="../style/cadastro_usuarios.css">
</head>
<body>
<div class="main">
        <div class="logo">
            <h1>ReelFriends</h1>
        </div>
        <div class="login-form">
    <form action="" method="post">
        <fieldset>
            <h2>Cadastro</h2>
        
            <input type="email" name="email" id="email" placeholder="Digite seu email..." required>

            <input type="text" name="username" id="username" placeholder="digite seu nome de usuário..." required>

            <input type="password" name="senha1" id="senha" placeholder="Digite sua senha..." required>
            <input type="password" name="senha2" id="senha" placeholder="Confirme sua senha..." required>

            <button type="submit" name="enviar">Enviar</button>

            <p>Já possui uma conta? Clique <a href="index.php">aqui</a>!</p>
        </fieldset>
    </form>




    <?php 
        if(isset($_POST["enviar"])){
            $sql = new MySQL;

            $rows = $sql->pesquisaEmailUsuario($_POST["email"]); //pesquisa o email inserido

            if($rows == null){ //verifica se existe algum email igual cadastrado

                if($_POST["senha1"] == $_POST["senha2"]){ //verifica se as senhas digitadas são iguais

                    $rows = $sql->pesquisaNomeUsuario($_POST["username"]); //pesquisa o nome de usuário inserido

                    if($rows == null){  //verifica se existe algum usuário com aquele mesmo username
                        $username = $_POST["username"];
                        $email = $_POST["email"];    
                        $senha = hash("sha512", md5($_POST["senha1"]));

                        $sql->cadastraUsuario($username, $email, $senha); //cadastra o usuário com as informações passadas
                    
                    } else {
                        echo "[ERRO] Este nome de usuário já está sendo utilizado!";
                    } 

                } else {
                    echo "[ERRO] As senhas digitadas não são iguais!";
                }

            } else {
                echo "[ERRO] Esse e-mail já está cadastrado na plataforma!";
            }
        }
    ?>
        </div>
</div>
</body>
</html>