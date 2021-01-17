<?php 

//resibe un array de arrays asociativos y regresa codigo html
    //clase de la tabla para dar estilos individuales
    function convert_to_html_table($dataset,$css_classes=""){
        //obtiene las llaves del array asociativo y las use como nombre 
        //de cabeera para la tabla
        $table_headers='<tr>';
        $headers=array_keys($dataset[0]);
        
        foreach($headers as $header){
            $table_headers.="<th>{$header}</th>";
            
        }

        $table_headers.='</tr>';
        
        $table_rows='';
        //por cada item del array devuelve una fila de la tabla
        foreach($dataset as $row){
            $table_rows.='<tr>';
            foreach($row as $item){
                $table_rows.="<td>{$item}</td>";
            }
            $table_rows.='</tr>';
        }
        $html='<table class="'.$css_classes.'">'.$table_headers.' '.$table_rows.'</table>';
        return $html;

    }

?>