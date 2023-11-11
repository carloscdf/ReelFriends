<?php 
    class Usuario{
        private $username;
        private $email;
        private $perfil;

        function __construct($email)
        {
            include("../db/conexao.php");
            $search = $email;
            $search = "%".$search."%";
            $sql = "SELECT * FROM usuario WHERE email_usuario LIKE :s";
            $stmt = $PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->username = $rows[0]["nome_usuario"];
            
            $this->email = $rows[0]["email_usuario"];

            $this->perfil = "../img/".$rows[0]["nome_usuario"]."-".$rows[0]["idusuario"].".png";
        }

    }

    $teste = new Usuario("teste@teste.com");
    echo "<pre>";
    print_r($teste);
    echo "</pre>";
?>