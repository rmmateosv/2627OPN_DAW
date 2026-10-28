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
                'Bucket'=> $this->rutaUnica.strtolower($nombre)
            ]);
            $resultado = true;
        } catch (\Throwable $th) {
            $error[] = $th->getMessage();
        }
        return $resultado;
    }

    function obtenerEstanterias(){
        global $error;
        $resultado = array();
        try {
           $tmp = $this->conexion->listBuckets();
           foreach($tmp['Buckets'] as $t){
                //Solamente nos quedamos con los buckets de este proyecto
                $campos = explode('.',$t['Name']);
                $aux = $campos[0].'.'.(isset($campos[1])?$campos[1]:'').'.'.(isset($campos[2])?$campos[2]:'').'.';
                if($aux==$this->rutaUnica){
                    $resultado[]= array('clave'=>$t['Name'],'nombre'=>$campos[3]);
                }
           }
        } catch (\Throwable $th) {
            $error[] = $th->getMessage();
        }
        return $resultado;
    }

    function cargarLibro($bucket,$objeto,$fichero){
        global $error;
        $resultado = false;
        try {
            $this->conexion->putObject([
                'Bucket'=>$bucket,
                'Key'=>'libros/'.$objeto,
                'SourceFile' =>$fichero,
                'ContentType' => mime_content_type($fichero)
            ]);
            $resultado=true;
        } catch (\Throwable $th) {
            $error[] = $th->getMessage();
        }
        return $resultado;
    }
    function obtenerLibros($estanteria){
        $resultado = array();
        try {
            $tmp=$this->conexion->listObjectsV2([
                'Bucket' => $estanteria
            ]);
            //Tratamos los objetos de bucket y recuperamos
            //para cada uno el nombre, el tamaño y el tipo
            foreach($tmp['Contents'] as $t){
                $resultado[]= array('nombre'=>$t['Key'],'tamano'=>$t['Size'],
                    'tipo'=>$t['Type'],'fecha'=>$t['LastModified']);
            }
            
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