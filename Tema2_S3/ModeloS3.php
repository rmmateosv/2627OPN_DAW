<?php
require_once 'vendor/autoload.php';

use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

class ModeloS3{
    private $conexion;
    private $rutaUnica = 'rmmateosv01.2daw.tema2-s3.';

    function __construct(){
        //Usamos la variable global $error para devolver mensaje en caso de excepción
        global $error;
        //Establecer conexión con S3
        try {
           //Recuperar credenciales de acceso
            $proveedor = CredentialProvider::ini('default','.credenciales');
            $proveedor = CredentialProvider::memoize($proveedor);
            //conectar
            $this->conexion = new S3Client([
                'version' => 'latest',
                'region' => 'us-east-1',
                'credentials' => $proveedor
            ]);
        } catch (\Throwable $th) {
            $error[] = $th->getMessage();
        }
    }
    
    function crearEstanteria($nombre){
        global $error;
        $resultado = false;
        try {
            $this->conexion->createBucket([
                'Bucket'=> $this->rutaUnica.$nombre
            ]);
            $resultado = true;
        } catch (\Throwable $th) {
            $error[] = $th->getMessage();
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

    /**
     * Set the value of conexion
     *
     * @return  self
     */ 
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;

        return $this;
    }
}
?>