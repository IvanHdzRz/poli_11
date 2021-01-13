<?php 
    require 'conexion.php';
    require 'fetch_query.php';
    
    //cabeceras de respuesta html
    //permite solicitudes de culaquier origen
    header('Access-Control-Allow-Origin: *');
    //tipo de respuesta formato json
    header('Content-Type: application/json');
    
    //establece conexion con bd
    $con=get_connection();
    //si no lo logra manda error 500
    if($con['status']=='fail'){
        header("HTTP/1.1 500 Internal Server Error");
        echo "ha ocurrido un error durante la conexion a la base de datos, codigo:".$con['errorno'];
    //si lo logra consulta
    }else{
        //query costo competidores
        $queryCostosCompetencia='
    SELECT costos.idempresa as id_competidor, TRUNCATE((SUM(costos.costo_unitario_promedio*costos.unidades_requeridas_por_producto)),3) as costo_de_produccion
    FROM
    (select 
      e.idempresa,e.idalmacen,tipoalmacen.nbtipoalmacen as insumo, sum(e.unidades) as "unidades",sum(e.costoembarque) as "costo_total",
      (sum(e.costoembarque)/sum(e.unidades)) as "costo_unitario_promedio", prov.proveedor, 
      prov.coeficiente as "unidades_requeridas_por_producto"
     
     from embarque as e
     inner join tipoalmacen on e.idalmacen=tipoalmacen.idtipoalmacen
     inner join 
        (select (enc.idvendedora-4) as insumo, industria.nbindustria as proveedor,enc.coeficiente 
         from encadenamiento as enc 
         inner join industria on industria.idindustria=enc.idvendedora
         where idcompradora= (select idindustria from empresa where idempresa=11)
        ) as prov on  prov.insumo=e.idalmacen
     
     where e.idempresa in 
     (
      SELECT idempresa 
      FROM empresa 
      WHERE idindustria = (select idindustria from empresa where idempresa=11) && 
        idempresa !=11 && idempresa <=50 
     ) 
     group by e.idalmacen, e.idempresa
      order by e.idempresa) as costos
    group by costos.idempresa
    order by costo_de_produccion;
    ';
        
        
        
        $costo_competencia=fetch_to_array($queryCostosCompetencia,$con['con']);

        echo json_encode($costo_competencia,JSON_NUMERIC_CHECK);
     }

?>