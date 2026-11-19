<?php

use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

require_once 'vendor/autoload.php';

class Modelo{
    private $conexion;
    private $nombreB = 'rmmateosv01.2daw.tienda';

    function __construct()
    {
        try {
            //Cargar credenciales
            $credenciales = CredentialProvider::ini('default','.pepeCredenciales');
            $credenciales = CredentialProvider::memoize($credenciales);

            //Conectar con S3
            $this->conexion = new S3Client([
                'version' =>'latest',
                'region' =>'us-east-1',
                'credentials' => $credenciales
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    function subirProducto($texto,$nombreF){
        $resultado = false;
        try {
            //Crear un objeto en el bucket con el texto
            $this->conexion->putObject([
                'Bucket' =>$this->nombreB,
                'Key' =>$nombreF.'.html',
                'Body' =>$texto,
                'ContentType' => 'text/html;charset=utf-8'
            ]);
            $resultado = true;
        } catch (\Throwable $th) {
            throw $th;
        }
        return $resultado;
    }
    function obtenerProductos(){
        $resultado = array();
        try {
            //Crear un objeto en el bucket con el texto
            $tmp=$this->conexion->listObjectsV2([
                'Bucket'=>$this->nombreB
            ]);
            if(isset($tmp['Contents'])){
                foreach($tmp['Contents'] as $t){
                    $resultado[]=$this->conexion->getObjectUrl($this->nombreB, $t['Key']);
                }
            }            
        } catch (\Throwable $th) {
            throw $th;
        }
        return $resultado;
    }
    function obtenerURLBucket(){
        $resultado = null;
        try {
            //Crear un objeto en el bucket con el texto
            $resultado=$this->conexion->getObjectUrl($this->nombreB,'index.html');                       
        } catch (\Throwable $th) {
            throw $th;
        }
        return $resultado;
    }
    /**
     * Get the value of conexion
     */ 
    public function getConexion()
    {
        return $this->conexion;
    }

    

    
}
?>