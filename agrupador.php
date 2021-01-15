<?php 
    require './php/conexion.php';
    require './php/fetch_query.php';
    
    $con=get_connection();
    if($con['status']=='fail'){
        header("HTTP/1.1 500 Internal Server Error");
        echo "ha ocurrido un error durante la conexion a la base de datos, codigo:".$con['errorno'];
    }else{
        
        $getEmbarques= 'SELECT * FROM embarque WHERE idempresa=11';
        $embarques=fetch_to_array($getEmbarques,$con['con']);
        
        $insumos=[
            [
                'nombre'=>'insumoA',
                'id'=>1,
                'unidades'=>0,
                'costo_total'=>0,
                'costo_medio'=>0
            ],
            [
                'nombre'=>'insumoB',
                'id'=>2,
                'unidades'=>0,
                'costo_total'=>0,
                'costo_medio'=>0
            ]

            ];
        //calculo de los costos medios de los insumos
        foreach($embarques as $embarque){
            switch($embarque['idalmacen']){
                case "1": 
                    $insumos[0]['costo_total']+=(int) $embarque['costoembarque'];
                    $insumos[0]['unidades']+=(int) $embarque['unidades'];
                    break;
                case "2": 
                    $insumos[1]['costo_total']+=(int) $embarque['costoembarque'];
                    $insumos[1]['unidades']+=(int) $embarque['unidades'];
                    break;
            }
        }

        for($i=0;$i<count($insumos);$i++){
            $insumos[$i]['costo_medio']=number_format($insumos[$i]['costo_total']/$insumos[$i]['unidades'],2);
        }
        
        
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!--Fuentes -->
   <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;700&display=swap" rel="stylesheet">
    <!--Main css-->
    <link rel="stylesheet" href="agrupador.css">
    <title>Agrupador</title>
</head>
<body>
    <h2>Datos de mi empresa</h2>
    <div class="insumo_card_container">
        <?php 
            foreach($insumos as $insumo){
                echo '
                    <div class="insumo_card">
                        <h3 class="insumo_card_nombre">'.$insumo['nombre'].'</h3>
                        <h3 class="insumo_card_medio">Costo medio: $'.$insumo['costo_medio'].' </h3>
                        <p class="insumo_card_unidades">unidades: '.$insumo['unidades'].'</p>
                        <p class="insumo_card_total">costo total: $'.$insumo['costo_total'].'</p>
                    </div>
                ';
            }
        ?>
        
    </div>
    <h2>Datos de la industria</h2>
    <div class="chart">
        
        <div class="loader" id="loading_chart">
            
        </div>
        <div class="plot">
            <canvas id="market_chart" width="400" height="400"></canvas>
        </div>
        <div class="plot">
            <canvas id="prov_chart" width="400" height="400"></canvas>
        </div>
        <div class="plot">
            <canvas id="prov_chart2" width="400" height="400"></canvas>
        </div>
        
    </div>
    <div class="json">
        <h2>Datos en formato JSON</h2>
            <textarea name="json" id="json_data" cols="50" rows="15" readonly="true">
                <?php echo json_encode(['datos_agregados'=>$insumos,'embarques'=>$embarques],JSON_PRETTY_PRINT); ?>
            </textarea>
    </div>
    <script src="./js/agrupador_chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</body>
</html>