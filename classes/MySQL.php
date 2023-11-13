<?php 
    class MySQL{
        const MYSQL_HOST = "localhost";
        const MYSQL_USER = "root";
        const MYSQL_PASSWORD = "";
        const MYSQL_DB_NAME = "banco_reelfriends";
        private $PDO;

        function __construct()
        {
            try {
                $this->PDO = new PDO('mysql:host=' . MySQL::MYSQL_HOST . ';dbname=' . MySQL::MYSQL_DB_NAME, MySQL::MYSQL_USER, MySQL::MYSQL_PASSWORD);
                $this->PDO->exec("set names utf8");
            } catch (PDOException $e) {
                echo 'Erro ao conectar com o MySQL:' . $e->getMessage();
            }
        }

        function pesquisaEmailUsuario($email){
            $search = $email;
            $sql = "SELECT * FROM usuario WHERE email_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaNomeUsuario($username){
            $search = $_POST["username"];   
            $sql = "SELECT * FROM usuario WHERE nome_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function cadastraUsuario($username, $email, $senha){
            $sql = "INSERT into usuario(nome_usuario, email_usuario, senha_usuario) VALUES(:nome, :email, :senha)";

            $stmt = $this->PDO->prepare($sql);    //prepara
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
                session_start();
                $_SESSION["usuario"] = $email; //salva na session o email do usuário criado
                header("Location: feed.php");
            }
        }

        function pesquisaObras(){
            $sql = "SELECT * FROM producao";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }
    }
?>