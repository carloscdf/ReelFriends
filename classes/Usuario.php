<?php 
    class Usuario{
        private $username;
        private $email;
        private $perfil;
        private $id;

        function __construct($email)
        {
            $sql = new MySQL;

            $rows = $sql->pesquisaEmailUsuario($email);

            $this->username = $rows["nome_usuario"];
            
            $this->email = $rows["email_usuario"];

            $this->perfil = "../img/usuario/perfil/".$rows["nome_usuario"]."-".$rows["idusuario"].".png";

            $this->id = $rows["idusuario"];
        }

        function getNome(){
            return $this->username;
        }

        function getEmail(){
            return $this->email;
        }

        function getPerfil(){
            $fotos = glob($this->perfil);
            if($fotos == null){
                echo "<img class = 'foto-perfil' src='../img/usuario/perfil/0.png' alt='".$this->username."'>";
            }
            else{
                echo "<img class = 'foto-perfil' src='".$this->perfil."' alt='".$this->username."'>";
            }
        }

        function getId(){
            return $this->id;
        }
    }
?>