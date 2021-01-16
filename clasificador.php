<?php 
    //el orden de los require importa
    require './php/conexion.php';
    require './php/fetch_query.php';
    require './php/bd_meta_data.php';
    require './php/generete_querys.php';

    $con=get_connection();
    $conInfo_schema=get_connection('information_schema');
    if($con['status']=='fail'||$conInfo_schema['status']=='fail' ){
        header("HTTP/1.1 500 Internal Server Error");
        echo "ha ocurrido un error durante la conexion a la base de datos, codigo:".$con['errorno'];
    }else{
        //obtiene las tablas y campos de la bd mercado_polizona y establece valores por
        //defecto si estos no vienen en la peticion
        $bd_tables=get_bd_tables();
        $default_table=$bd_tables[5]['name'];
        $default_field_1=$bd_tables[5]['fields'][2];
        $default_field_2=$bd_tables[5]['fields'][0];
        //el usuario ha seleccionado tabla y campos? si no ponle los que estan por defecto
        $selected_table= isset($_GET['table'])?$_GET['table']:$default_table;
        $selected_field_1= isset($_GET['field_1'])?$_GET['field_1']:$default_field_1;
        $selected_field_2= isset($_GET['field_2'])?$_GET['field_2']:$default_field_2;
        //recuerda el valor de la tabla y campos que el usuaior habia seleccionado
        $key_selected_table=array_search($selected_table, array_column($bd_tables, 'name'));
        $key_selected_field_1=array_search($selected_field_1,$bd_tables[$key_selected_table]['fields'] );
        $key_selected_field_2=array_search($selected_field_2,$bd_tables[$key_selected_table]['fields'] );
        //generacion de querys
        $sql=generate_query($selected_table,$selected_field_1,$selected_field_2);
        
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
            <select name="table" id="select_table">
                <?php 
                    foreach($bd_tables as $index => $table){
                        $selected=$index==$key_selected_table?'selected':'';
                        echo '<option value="'.$table['name'].'"'.$selected.' >'.$table['name'].'</option>'; 
                    }
                ?>
                
            </select>
        </div>
        
        <div class="selector">
            <label for="field_1">Campo 1</label>
            <select name="field_1" id="select_field_1">
                <?php 
                    foreach($bd_tables[$key_selected_table]['fields'] as $index => $field){
                        $selected=$index==$key_selected_field_1?'selected':'';
                        echo '<option value="'.$field.'"'.$selected.' >'.$field.'</option>'; 
                    }
                ?>
            </select>
        </div>

        <div class="selector">
            <label for="field_2">Campo 2:</label>
            <select name="field_2" id="select_field_2">
                <?php 
                    foreach($bd_tables[$key_selected_table]['fields'] as $index => $field){
                        $selected=$index==$key_selected_field_2?'selected':'';
                        echo '<option value="'.$field.'"'.$selected.' >'.$field.'</option>'; 
                    }
                ?>
            </select>
        </div>

         <input type="submit" value="Crear Query">
        </form>
    </div>
    <div class="querys">
        <textarea name="query1" id="query1" cols="50" rows="15" readonly="true">
            <?php echo $sql['query1']; ?>
        </textarea>
        <textarea name="query2" id="query2" cols="50" rows="15" readonly="true">
            <?php echo $sql['query2']; ?>
        </textarea>           
    </div>
    <script>
        const bd_tables=JSON.parse('<?php echo json_encode($bd_tables) ?>');
    </script>
    <script src="./js/clasificador.js"></script>
</body>
</html>