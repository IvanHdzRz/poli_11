'use strict'

window.onload = (e) => {
    const plot_chart=async ()=>{
        const req=await fetch('http://polizona.com/mercado/11/php/costo_competidores.php');
        const req2= await fetch('http://polizona.com/mercado/11/php/costo_proveedores.php');
        const data=await req.json();
        const data_prov=await req2.json();
        const ctx = document.getElementById('market_chart').getContext('2d');
        const ctx2 = document.getElementById('prov_chart').getContext('2d');
        const ctx3 = document.getElementById('prov_chart2').getContext('2d');
        const loader=document.getElementById('loading_chart')
        loader.style.display='none';
        
        const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(comp=>`empresa ${comp.id_competidor}`),
            datasets: [{
                label: 'costo de produccion de la industria ',
                backgroundColor: '#5a5afb',
                borderColor: '#5a5afb',
                data: data.map(comp=>comp.costo_de_produccion),
                    
            }]
        },
        options: {}
        });

        const chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: data_prov
                    .filter(prov=>prov.nombre_insumo==='insumo A')
                    .map(prov=>`empresa ${prov.proveedor}`),
                datasets: [{
                    label: 'costo de produccion de proveedores de insumo A',
                    backgroundColor: '#2e9afd',
                    borderColor: '#2e9afd',
                    data: data_prov
                        .filter(prov=>prov.nombre_insumo==='insumo A')
                        .map(prov=>prov.costo_de_produccion),
                    
                        
                },
                
            ]
            },
            options: {}
            });
            const chart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: data_prov
                        .filter(prov=>prov.nombre_insumo==='insumo B')
                        .map(prov=>`empresa ${prov.proveedor}`),
                    datasets: [{
                        label: 'costo de produccion de proveedores de insumo B',
                        backgroundColor: '#fff',
                        borderColor: '#fff',
                        data: data_prov
                            .filter(prov=>prov.nombre_insumo==='insumo B')
                            .map(prov=>prov.costo_de_produccion),
                        
                            
                    },
                    
                ]
                },
                options: {}
                });

    }
   
    plot_chart();
  }

