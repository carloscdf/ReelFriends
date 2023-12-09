<?php 
    include("../classes/MySQL.php");

    if(isset($_GET["id"])){
        $sql = new MySQL;

        $sql->apagarComentario($_GET["id"]);
        header("Location: pagina-producao.php?prod=".$_GET["prod"]);
    } else {
        header("Location: feed.php");
    }
?>