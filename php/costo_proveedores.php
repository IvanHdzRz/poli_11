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
        SELECT cm.idempresa AS proveedor,em.idindustria,pivot.id_insumo,al.nbtipoalmacen AS nombre_insumo,TRUNCATE(SUM(cm.costo_medio*co.coeficiente),3) AS costo_de_produccion
    FROM (
        SELECT idempresa, idalmacen,  (SUM(costoembarque)/SUM(unidades)) as costo_medio
        FROM embarque
        GROUP BY idempresa,idalmacen
    ) as cm
    INNER JOIN empresa as em ON em.idempresa=cm.idempresa
    INNER JOIN (
    SELECT pivot.idcompradora,pivot.idvendedora, pivot.id_insumo,pivot.coeficiente 
    FROM (
        SELECT idcompradora,idvendedora, 
        IF(idcompradora<5,idvendedora-idcompradora,
        IF(idcompradora=5&& idvendedora=6,2,idvendedora)) 
        as id_insumo,coeficiente 
        FROM encadenamiento 
    ) as pivot 
    WHERE idcompradora in 
    (SELECT idvendedora from encadenamiento WHERE idcompradora in 
        (SELECT idindustria FROM empresa where idempresa=11 
        ) 
    )
    ) as co ON co.idcompradora=em.idindustria && co.id_insumo=cm.idalmacen
    INNER JOIN (
    SELECT idcompradora,idvendedora, 
        IF(idcompradora<5,idvendedora-idcompradora,
        IF(idcompradora=5&& idvendedora=6,2,idvendedora)) 
        as id_insumo,coeficiente FROM encadenamiento where idcompradora=(SELECT idindustria FROM empresa where idempresa=11 )
    ) as pivot ON pivot.idvendedora=em.idindustria
    INNER JOIN tipoalmacen AS al ON  pivot.id_insumo=al.idtipoalmacen
    GROUP BY cm.idempresa
    HAVING proveedor<=50
    ORDER BY costo_de_produccion;
    ';
        
        
        
        $costo_competencia=fetch_to_array($queryCostosCompetencia,$con['con']);

        echo json_encode($costo_competencia,JSON_NUMERIC_CHECK);
     }

?>