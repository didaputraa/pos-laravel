<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <p class="card-title">Laporan penjualan</p>
        </div>
        <div class="card-body">
			<div class="form-group">
				<label>Pilih minggu pada bulan ini</label>
				<select class="form-control" id="minggu"  onChange="createGrafik()">
					@foreach([1,2,3,4,5] as $i)
					<option value="{{ $i-1 }}">{{ $i }}</option>
					@endforeach
				</select>
			</div>
            <canvas id="grafik-penjualan" style="max-height:400px"></canvas>
        </div>
    </div>

	<script>
	$('#minggu').val({{ $minggu }});
	
	function createGrafik()
	{
		let jumlah  = {},
			x       = '',
			data    = [],
			minggu	= $('#minggu').val();
		
		$.ajax({
			url:"{{ url('/api/laporan/nota') }}/"+minggu
		}).done(evt =>{
			let tanggal = evt;
			
			tanggal.tbl.forEach(e=>
			{
				x = tgl(e.TglPesan);

				if(!jumlah[x])
				{
					jumlah[x] = 1;
				}
				else
				{
					jumlah[x] += 1;
				}
			});
			
			for(let i=0; i<7; i++)
			{
				if(jumlah[i])
				{
					data.push(jumlah[i]);
				}
			}

			let grafixLaporan = $('#grafik-penjualan').get(0).getContext('2d');

			let dataGrafix = {
				labels : tanggal.hari,
				datasets:[
					{
						borderColor	: '#2c92ff',
						data		: data,
						fill		: false
					}
				]
			};

			new Chart(grafixLaporan,{
				type:'line',
				data: dataGrafix,
				responsive:true,
				options:{
					scales:{
						xAxes:[{
							gridLines:{ display:false }
					}]},
					legend:{
						display:false
					}
				}
			});
		}).fail(e=>{
			console.log(e);
		});
	}
	
	function tgl(t){
		let tgl =  new Date(t);

		return tgl.getDay();
	}

	createGrafik();
	
	window.livewire.on('initialize-grafix',function(){
		createGrafik();
	});
	</script>
</div>