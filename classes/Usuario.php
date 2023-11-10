<?php 

    class Usuario{
        private $username;
        private $email;
        private $perfil;

        function __construct($id)
        {
            include("../db/conexao.php");
            $search = $id;
            $search = "%".$search."%";
            $sql = "SELECT nome_usuario FROM usuario WHERE idusuario LIKE :s";
            $stmt = $PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->username = $rows[0]["nome_usuario"];
            
            $search = $id;
            $search = "%".$search."%";
            $sql = "SELECT email_usuario FROM usuario WHERE idusuario LIKE :s";
            $stmt = $PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->email = $rows[0]["email_usuario"];

            $search = $id;
            $search = "%".$search."%";
            $sql = "SELECT nome_usuario FROM usuario WHERE idusuario LIKE :s";
            $stmt = $PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->perfil = "../img/".$rows[0]["nome_usuario"].".png";
        }

    }

    $teste = new Usuario(1);
    echo "<pre>";
    print_r($teste);
    echo "</pre>";
?>