<?php 
    require './php/conexion.php';
    require './php/fetch_query.php';
    
    $con=get_connection();
    if($con['status']=='fail'){
        header("HTTP/1.1 500 Internal Server Error");
        echo "ha ocurrido un error durante la conexion a la base de datos, codigo:".$con['errorno'];
    }else{
        
        $query= 'SELECT * FROM embarque WHERE idempresa=11';
        $data=fetch_to_array($query,$con['con']);
        var_dump($data);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrupador</title>
</head>
<body>
    <h2>Datos de mi empresa</h2>
</body>
</html>