<?php 
    class Usuario{
        private $username;
        private $email;
        private $perfil;
        private $banner;
        private $id;

        function __construct($email)
        {
            $sql = new MySQL;

            $rows = $sql->pesquisaEmailUsuario($email);

            $this->username = $rows["nome_usuario"];
            
            $this->email = $rows["email_usuario"];

            $this->perfil = "../img/usuario/perfil/".$rows["nome_usuario"]."-".$rows["idusuario"].".png";

            $this->banner = "../img/usuario/banner/".$rows["nome_usuario"]."-".$rows["idusuario"].".png";

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
                echo "../img/usuario/perfil/0.png";
            }
            else{
                echo $this->perfil;
            }
        }

        function getBanner(){
            $fotos = glob($this->banner);
            if($fotos == null){
                echo "../img/usuario/banner/0.png";
            }
            else{
                echo $this->banner;
            }
        }

        function getId(){
            return $this->id;
        }
    }
?>