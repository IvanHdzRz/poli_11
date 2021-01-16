<?php 
    function get_connection($schema='polizona_mercado'){
        $con=mysqli_connect('68.70.164.26','polizona_lectura','Polizona-1',$schema);
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