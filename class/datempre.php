<?php

class Empresa {
    public $razon;
    public $propietario;
    public $gerente;
    public $direccion;
    public $telefono;
    public $email;
    public $webpage;
    
function regempresa($razon, $propietario, $gerente, $direccion, $telefono, $email, $webpage){
//    $nom_arc = "datempre";
    $nombre_archivo = "document/datempre";
//    if (file_exists($nombre_archivo)) {
//        echo "<script> alert('YA EXISTE UNA EMPRESA') </script>";
//    }else{
        if($archivo = fopen($nombre_archivo, "w")){
            fwrite($archivo, $razon . PHP_EOL);
            fwrite($archivo, $propietario . PHP_EOL);
            fwrite($archivo, $gerente . PHP_EOL);
            fwrite($archivo, $direccion . PHP_EOL);
            fwrite($archivo, $telefono . PHP_EOL);
            fwrite($archivo, $email . PHP_EOL);
            fwrite($archivo, $webpage . PHP_EOL);        
//            if(fwrite($archivo, "#". $razon ."#".$propietario."#".$gerente."#".$direccion."#".$telefono."#".$email."#".$webpage."#"."\n")){
    //            echo "Se ha ejecutado correctamente";
//            }else{
//                echo "Ha habido un problema al crear el archivo";
//            fclose($archivo);
//        }                
//    }
    }
}
function mostrarempresa(){
//    $nom_arc = $fec_arc;
    $nombre_archivo = "document/datempre"; 
    $todos_los_datos=file($nombre_archivo);
    $campo1=rtrim($todos_los_datos[0]);
    $campo2=rtrim($todos_los_datos[1]);
    $campo3=rtrim($todos_los_datos[2]);
    $campo4=rtrim($todos_los_datos[3]);    
    $campo5=rtrim($todos_los_datos[4]);
    $campo6=rtrim($todos_los_datos[5]);
    $campo7=rtrim($todos_los_datos[6]);
//    if(file_exists($nombre_archivo)){
//        echo  nl2br(file_get_contents($nombre_archivo));
//    }else{
//        $mensaje = "El archivo no existe";
//    }   
?>
            <form action="inicio.php" method="POST">
                <label>Raz&oacute;n social:</label>&nbsp;<input type="text" name="razon" value="<?php echo $campo1 ?>" style="text-transform:uppercase; width: 600px;" onkeyup="this.value=this.value.toUpperCase();"/>
                <br><br>
                <label>Propietario</label>&nbsp;<input type="text" name="propietario" value="<?php echo $campo2 ?>" style="text-transform:uppercase; width: 250px" onkeyup="this.value=this.value.toUpperCase();"/> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>Gerente / Encargado:</label> &nbsp;<input type="text" name="gerente" value="<?php echo $campo3 ?>" style="text-transform:uppercase; width: 250px;" onkeyup="this.value=this.value.toUpperCase();"/>
                <br><br>
                <label>Direcci&oacute;n:</label>&nbsp;<input type="text" name="direccion" value="<?php echo $campo4 ?>" style="text-transform:uppercase; width: 400px;" onkeyup="this.value=this.value.toUpperCase();"/>
                <br><br>
                <label>Tel&eacute;fonos:</label>&nbsp;<input type="text" name="telefono" value="<?php echo $campo5 ?>" style="text-transform:uppercase; width: 200px;" onkeyup="this.value=this.value.toUpperCase();"/> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>Correo Electr&oacute;nico:</label>&nbsp;<input type="text" name="email" value="<?php echo $campo6 ?>" style=" width: 200px;" />                 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>P&aacute;gina Web:</label>&nbsp;<input type="text" name="webpage" value="<?php echo $campo7 ?>" style=" width: 200px;" /> 
                <br><br>
                <input type="submit" name="inserta_empresa" value="GUARDAR">
                &nbsp;&nbsp;
                <input type="reset" value="CANCELAR">
                &nbsp;&nbsp;
                <input type="submit" name="salir_admin" value="SALIR">
            </form>    
<?php   
}
}