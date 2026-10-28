<?php 
require_once 'ModeloS3.php';

$modelo = new ModeloS3();
if($modelo->getConexion()==null){
    $error[] = 'NO HAY CONEXIÓN';
}
if(isset($_POST['crearE'])){
    //Pulsado crear Estantería
    //Comporbar que se ha rellenado el nombre de la estantería
    if(empty($_POST['estanteria'])){
        $error[]='Rellena el nombre de la estantería';
    }
    else{
        if($modelo->crearEstanteria($_POST['estanteria'])){
            $mensajes[]='Estantería creada';
        }
        else{
            $error[] = 'Error al crear la estantería';
        }
    }
}
//Obtener las estanterías/buckets para rellenar el select
$estanterias = $modelo->obtenerEstanterias();
if(empty($estanterias)){
    $estaneriaSel=null;
}
else{
    //Si hay una estantería seleccionada, se elige esta
    //Si no, se elige la primera del array
    if(isset($_POST['estanteria'])){
        $estaneriaSel = $_POST['estanteria'];
    }
    else{
        $estaneriaSel = $estanterias[0]['clave'];
    }
    //Obtener libros de la estantería seleccioda
    $libros = $modelo->obtenerLibros($estaneriaSel);
}
if(isset($_POST['cargar'])){
    if(empty($_FILES['libro']['name'])){
        $error[]='No has seleccionado el libro';
    }
    else{
        //Subirlo a S3
        if($modelo->cargarLibro($_POST['estanteria'],
                                $_FILES['libro']['name'],
                                $_FILES['libro']['tmp_name'])){
            $mensajes[]='Libro cargado';
        }
        else{
            $error[]='Error al cargar el libro';
        }
    }
}
?>