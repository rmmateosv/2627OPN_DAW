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
    <h1>BIBLIOTECA IES AUGUSTÓBRIGA</h1>
    <form action="" method="post">
        <h3>Crear Estantería (Crear bucket)</h3>
        <label for="">Nombre de la estantería</label>
        <input type="text" name="estanteria" id="" placeholder="Nombre Estantería">
        <button type="submit" name="crearE">Crear</button>
    </form>

    <?php 
    //Mostrar errores
    if(isset($error)){
        foreach($error as $e){
            echo '<h3 style="color:red">'.$e.'</h3>';
        }
    }
    //Mostrar mensajes
    if(isset($mensajes)){
        foreach($mensajes as $m){
            echo '<h3 style="color:green">'.$m.'</h3>';
        }
    }
    ?>
</body>
</html>