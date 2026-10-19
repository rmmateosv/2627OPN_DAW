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
?>