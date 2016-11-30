<?php
date_default_timezone_set("America/Guayaquil");
class Registro {
    private $fecha;
    private $usuario;
    private $accion;
    public $mensaje;
    public $fec_arc;
    
function registrar($mensaje){
    $nom_arc = date('dmY');
    $nombre_archivo = "document/$nom_arc";
    if($archivo = fopen($nombre_archivo, "a")){
        if(fwrite($archivo, "# ".date("d-m-Y // H:i:s"). " ". $mensaje. "\n")){
//            echo "Se ha ejecutado correctamente";
        }else{
            echo "Ha habido un problema al crear el archivo";
        }
        fclose($archivo);
    }        
}
function mostrar($fec_arc){
    $nom_arc = $fec_arc;
    $nombre_archivo = "document/$nom_arc";            
    if(file_exists($nombre_archivo)){
        echo  nl2br(file_get_contents($nombre_archivo));
    }else{
        $mensaje = "El archivo no existe";
    }    
}
}
