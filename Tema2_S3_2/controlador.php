<?php
require_once 'Modelo.php';

//Conectar
$s3 = new Modelo();
if($s3->getConexion()==null){
    echo 'No hay conexión con S3';
}
else{
    if(isset($_POST['cargar']) and !empty($_FILES['fichero']['name'])){
        //Leer los datos del fichero y pasarlos a un array
        $productos = file($_FILES['fichero']['tmp_name']);
        foreach($productos as $p){
            //Generar un texto con el html de este producto
            //Seperar los datos del producto
            $datos = explode(';',$p);
            $texto = '<!DOCTYPE html>';
            $texto .= '<html lang="en">';
            $texto .= '<head>';
            $texto .= '<meta charset="UTF-8">';
            $texto .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $texto .= '<title>Document</title>';
            $texto .= '</head>';
            $texto .= '<body>';
            $texto .= '<p>Producto:'.$datos[0];
            $texto .= '<p>Nombre:'.$datos[1];
            $texto .= '<p>Stock:'.$datos[2];
            $texto .= '</body>'; 
            $texto .= '</html>';
            if(!$s3->subirProducto($texto,$datos[0])){
                echo 'Error al subir el producto '.$datos[0];
            }
        }
    }
}
?>