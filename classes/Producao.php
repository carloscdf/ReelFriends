<?php 
    class Producao{
        private $titulo;
        private $sinopse;
        private $genero;
        private $categoria;
        private $diretor;
        private $capa;

        function __construct($titulo, $sinopse, $genero, $categoria, $diretor)
        {
            $sql = new MySQL;
            
            $this->titulo = $titulo;
            $this->sinopse = $sinopse;

            $this->genero = $sql->pesquisaIdGenero($genero);
            $this->categoria = $sql->pesquisaIdCategoria($categoria);
            $this->diretor = $sql->pesquisaIdDiretor($diretor);

            $this->capa = "../img/producao/capa/$titulo-$diretor.png";
        }

        function getTitulo(){
            return $this->titulo;
        }

        function getSinopse(){
            return $this->sinopse;
        }

        function getGenero(){
            return $this->genero;
        }

        function getCategoria(){
            return $this->categoria;
        }

        function getDiretor(){
            return $this->diretor;
        }

        function getCapa(){
            return $this->capa;
        }
    }
?>