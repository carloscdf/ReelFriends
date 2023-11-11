<?php 
    include("../db/conexao.php");
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

            <p>Não possui uma conta? Clique <a href="cadastro.php">aqui</a>!</p>
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

            if($rows != null){
                $senha = hash("sha512", md5($_POST["senha"]));

                if($rows[0]["senha_usuario"]==$senha){
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