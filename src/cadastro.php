<?php 
    include("../db/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se!</title>

    <link rel="stylesheet" href="../style/cadastro.css">
</head>
<body>
    <h1>ReelFriends</h1>

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
            $search = $_POST["email"];  //pesquisa o email inserido
            $sql = "SELECT * FROM usuario WHERE email_usuario LIKE :s";
            $stmt = $PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){  //verifica se existe algum email igual cadastrado
                if($_POST["senha1"] == $_POST["senha2"]){   //verifica se as senhas digitadas são iguais

                    $search = $_POST["username"];   //pesquisa o nome de usuário inserido
                    $sql = "SELECT * FROM usuario WHERE nome_usuario LIKE :s";
                    $stmt = $PDO->prepare($sql);    //prepara
                    $stmt->bindParam(':s', $search);    //vincula
                    $result = $stmt->execute();    //executa
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if($rows == null){  //verifica se existe algum usuário com aquele mesmo username
                        $username = $_POST["username"];
                        $email = $_POST["email"];    
                        $senha = hash("sha512", md5($_POST["senha1"]));
                        
                        $sql = "INSERT into usuario(nome_usuario, email_usuario, senha_usuario) VALUES(:nome, :email, :senha)";

                        $stmt = $PDO->prepare($sql);    //prepara
                        $stmt->bindParam(':nome', $username);   //vincula
                        $stmt->bindParam(':email', $email);     //vincula
                        $stmt->bindParam(':senha', $senha);     //vincula

                        $result = $stmt->execute();     //executa

                        if(!$result){
                            var_dump($stmt->errorInfo());
                            exit;
                        }
                        else{
                            echo $stmt->rowCount()." linhas inseridas";
                            header("Location: redirect.php");      //redirecionamento com JavaScript
                        }
                    
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

</body>
</html>