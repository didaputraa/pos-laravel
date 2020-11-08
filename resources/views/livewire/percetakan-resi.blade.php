<div class="col-lg-12">
    @if(empty($printing))
	<div class="card">
        <div class="card-header">
            <h3 class="card-title">Percetakan No resi</h3>
        </div>
        <div class="card-body">
            <table class="table" id="tbl">
                <thead>
                    <tr>
                        <th>Konsumen </th>
                        <th>Tgl Pesan</th>
                        <th>Tgl Kirim</th>
                        <th>Total order</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
			</table>
		</div>
	</div>
	<script>
	function initTable()
	{
		$('#tbl').DataTable({
			data: {!! $tbl !!},
			columns:[
				{data:'Nama'},
				{data:'pesan'},
				{data:'kirim'},
				{
					data:'total',
					render:function(item)
					{
						return 'Rp '+Number(item).toLocaleString();
					}
				},
				{
					data:'IDOrder',
					render:function(item, type, row)
					{
						if(row.ekspedisi != 0)
						{
							return `<button class="btn text-primary" onClick="preparePrint('${item}')"><i class="fa fa-print"></i></button>`;
						}
						else
						{
							return '';
						}
					}
				},
			]
		});
	}
	
	initTable();
	
	function preparePrint(idItem)
	{
		@this.call('preparePrinting', idItem);
	}
	</script>
	@else
	<style>
	@media print{
		*{background-color:#fff}
		
		.card-header, .backs, footer{
			display:none
		}
	}
	</style>
	<button class="btn btn-primary mb-3 backs" wire:click="backViewer">Kembali</button>
	<button class="btn text-primary float-right backs" onClick="window.print()"><i class="fa fa-2x fa-print"></i></button>
	<div class="card">
        <div class="card-header">
            <h3 class="card-title">No resi</h3>
        </div>
        <div class="card-body">
			<p class="text-center text-sm">
			{{ $fitur->Nama }}<br>
			{{ $fitur->Alamat }}<br>
			telp: {{ $fitur->NoTelp }}, Email: {{ $fitur->Email }}
			</p>
			<p class="border">RESI CODE: <span class="text-primary">{{ $noResi->NoResi }}</span></p>
			<p class="border">EKSPEDISI: <span class="text-primary">{{ $noResi->getEkspedisi->Nama }}</span></p>
		</div>
	</div>
	@endif
</div>
