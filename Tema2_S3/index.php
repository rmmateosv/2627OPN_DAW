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
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Gestionar Libros</h3>
        <label for="">Nombre de la estantería</label>
        <select name="estanteria" id="">
            <?php 
            //Cada bucket va a ser un option
            foreach($estanterias as $e){
                echo '<option value="'.$e['clave'].'">'.$e['nombre'].'</option>';
            }
             ?>
        </select>
        <br>
        <label for="">Selecciona libro</label>
        <input type="file" name="libro" id="">
        <button type="submit" name="cargar">Poner Libro en Estantería</button>
        <!-- TAbla para mostrar los libros cargados -->
        <p/> 
        
        <table border="1">
            <tr>
                <td>Libro</td>
                <td>Tamaño</td>
                <td>Tipo</td>
                <td>Fecha Modificación</td>
            </tr>
            <?php 
            if($estaneriaSel!=null){ 
                foreach($libros as $lib){
                    echo '<td>'.$lib['nombre'].'</td>';
                    echo '<td>'.$lib['tamano'].'</td>';
                    echo '<td>'.$lib['tipo'].'</td>';
                    echo '<td>'.$lib['fecha'].'</td>';
                }
            }
            ?>
         </table>
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