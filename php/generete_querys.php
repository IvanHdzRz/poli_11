<?php 
    function generate_query($table,$field_1,$field_2){
        $sql_1="
        SELECT {$field_1} , COUNT(*)/(SELECT COUNT(*) FROM {$table}) AS 'probabilidad'  
        FROM {$table} 
        WHERE {$field_1} IN( SELECT DISTINCT {$field_1} FROM {$table}) 
        GROUP BY {$field_1};
    ";

    $sql_2="
        SELECT {$field_1} ,{$field_2} , COUNT(*)/(SELECT COUNT(*) FROM {$table}) AS 'probabilidad'  
        FROM {$table} 
        WHERE 
            {$field_1}   IN 
            (SELECT DISTINCT {$field_1}  FROM {$table}) AND 
            {$field_2} IN ( SELECT DISTINCT {$field_2} FROM {$table}) 
        GROUP BY {$field_2},{$field_1}  
        ORDER BY {$field_1} , {$field_2};
    ";

     return ['query1'=>$sql_1,'query2'=>$sql_2];
    }

?>