<?php 
    function get_connection(){
        $con=mysqli_connect('68.70.164.26','polizona_lectura','Polizona-1','polizona_mercado');
        //comprueba conexion correcta
        $error=mysqli_connect_errno();
        if(!$error){
            mysqli_query($con,"SET names 'utf-8'");
        }
        
        return [
            'status'=>$error?'fail':'success',
            'con'=>$con,
            'errorno'=>$error
        ];
        
    }

?>