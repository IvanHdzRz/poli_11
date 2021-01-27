<?php 
    

    function get_bd_tables(){
        $conInfo_schema=get_connection('information_schema');
        $queryTables= '
            SELECT TABLE_NAME as nombre_tabla
            FROM TABLES
            WHERE TABLE_SCHEMA="polizona_11";
            ';
        $tables=fetch_to_array($queryTables,$conInfo_schema['con']);
        $bd_tables=[];
        $query_columns;
        foreach($tables as $record){
            //por cada registro de tabla hacer un query para saber sus campos 
            //y ponerlos en el array assoc
            $query_fields='
                    SELECT COLUMN_NAME AS campos 
                    FROM COLUMNS 
                    WHERE TABLE_SCHEMA = "polizona_11" AND TABLE_NAME ="'.$record['nombre_tabla'].'"';

            $fields_assoc=fetch_to_array($query_fields,$conInfo_schema['con']);
            $fields=[];
            foreach($fields_assoc as $field){
                $fields[]=$field['campos'];
            }

            $bd_tables[]=['name'=>$record['nombre_tabla'],'fields'=>$fields];
            
        }
        
        return $bd_tables;
    }
    
    
?>