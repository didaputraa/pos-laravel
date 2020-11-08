<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <p class="card-title">Laporan untung rugi</p>
        </div>
        <div class="card-body">
            <canvas id="grafix-penjualan" styles="height:200px"></canvas>
        </div>
    </div>

    <script> 
        function createGrafix()
        {
            let penjualans = {!! $penjualan !!},
                penjualan  = [];
            let pembelians = {!! $pembelian !!},
                pembelian  = [];
                
            let data1 = [], data2 = [];
             
            let grafixLaporan = $('#grafix-penjualan').get(0).getContext('2d');
            let tmp = [];

            pembelians.forEach(e=>{
                pembelian.push(e.pembelian);
            });

            penjualans.forEach((e,i)=>{
                penjualan.push(e.penjualan);
            });

            let a = 0, b = 0;
            
            for(let i=0; i< penjualan.length; i++)
            {
                a = Number(pembelian[i]);
                b = Number(penjualan[i]);

                if(a > b)
                {
                    data2.push(a - b);
                    data1.push(0);
                }
                else if(b > a)
                {
                    data1.push(b - a);
                    data2.push(0);
                }
            }

            let dataGrafix =
            {
                labels : [{!! $bulan !!}],
                datasets:[
                    {
                        label       : 'Keuntungan',
                        borderColor	: 'green',
                        fill		: false,
                        data		: data1,
                    },
                    {
                        label       : 'Kerugian',
                        borderColor	: 'red',
                        fill		: false,
                        data		: data2,
                    }
                ]
            };
            
            new Chart(grafixLaporan,{
                type:'line',
                data: dataGrafix,
                options:{
                    scales:{
                        xAxes:[{
                            gridLines:{
                                display:false
                            }
                        }]
                    },
                    legend:{
                        display:true
                    },
                    responsive : true,
                    maintainAspectRatio :true
                }
            });
        }

        createGrafix();
    </script>
</div>
