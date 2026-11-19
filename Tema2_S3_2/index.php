<?php
require_once 'controlador.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>CARGA DE PRODUCTOS</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="">Fichero</label>
        <input type="file" name="fichero" id="">
        <button type="submit" name="cargar">Cargar</button>
    </form>
    <h2>Productos cargados</h2>
    <?php 
    if(isset($subidos)){
        echo '<ul>';
        foreach($subidos as $s){
            echo '<li><a href="'.$s.'">'.$s.'</a>';
        }
        echo '</ul>';
    }
     if(isset($urlB)){
        echo '<h2><a href="'.$urlB.'">Pulsa para acceder al bucket</a></h2>';    
     }
     ?>
</body>
</html>