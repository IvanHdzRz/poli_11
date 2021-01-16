<?php 
    require './php/conexion.php';
    require './php/fetch_query.php';
    
    $con=get_connection();
    if($con['status']=='fail'){
        header("HTTP/1.1 500 Internal Server Error");
        echo "ha ocurrido un error durante la conexion a la base de datos, codigo:".$con['errorno'];
    }else{
        
        $get_bd_tables= 'SELECT * FROM embarque WHERE idempresa=11';
        $embarques=fetch_to_array($getEmbarques,$con['con']);

        $selected_table= isset($_GET['table'])?$_GET['table']:
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificador</title>
</head>
<body>
    <div class="table_selectors">
        <h2>Generador de super querys</h2>
        <form action="">
        
        <div class="selector">
            <label for="table">Elije una tabla</label>
            <select name="table" id="table">
                <option value="volvo">Volvo</option>
            </select>
        </div>
        
        <div class="selector">
            <label for="field_1">Campo 1</label>
            <select name="field_1" id="field_1">
                <option value="volvo">Volvo</option>
            </select>
        </div>

        <div class="selector">
            <label for="field_2">Campo 2:</label>
            <select name="field_2" id="field_2">
                <option value="volvo">Volvo</option>
            </select>
        </div>

         <input type="submit" value="Crear Query">
        </form>
    </div>
</body>
</html>