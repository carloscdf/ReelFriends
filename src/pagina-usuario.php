<?php
session_start();
if(isset($_SESSION["usuario"])){

    include("../classes/MySQL.php");
    include("../classes/Usuario.php");
    include("../classes/Producao.php");
    
    $usuario = new Usuario($_SESSION["usuario"]);    

    $sql = new MySQL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        
<?php 
} else {
    header("Location: index.php");
}
?>
</body>
</html>