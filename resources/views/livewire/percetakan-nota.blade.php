<div class="col-lg-12">
<style>
@media print{
	*{background-color:white}
	footer,.btn-kembali{
		display:none;
	}
	
}
</style>
@if($print)
	<button class="btn btn-primary mb-3 btn-kembali" wire:click="kembali">Kembali</button>
	<button class="btn text-primary float-right btn-kembali" onClick="window.print()"><i class="fa fa-2x fa-print"></i></button>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12 text-center"><b>{{ $perusahaan['nama'] }}</b><br>Alamat:{{ $perusahaan['alamat'] }}</div>
				<div class="col-sm-6">
					<label>Tanggal pesan</label>
					<p>{{ date('d-m-Y H:i:s',strtotime($order->TglPesan)) }}</p>
				</div>
				<div class="col-sm-6 text-right">
					<label>Ongkir</label>
					<p>{{ number_format($order->Ongkir,0,",",".") }}</p>
				</div>
			</div>
			<div>
				<table class="table table-sm">
					<tr>
						<th>Item</th>
						<th>Jumlah</th>
						<th>Harga</th>
					</tr>
					@foreach(App\OrderItem::where('IDOrder',$order->IDOrder)->get() as $r)
					<tr>
						<td>{{ $r->getHarga->getStok->getBarang->Nama." ".$r->getHarga->getStok->getBarang->getJenis->Nama }}</td>
						<td>{{ $r->Jumlah }}</td>
						<td>Rp {{ number_format($r->Harga,0,",",".") }}</td>
					</tr>
					@php $tot += ($r->Jumlah * $r->Harga) @endphp
					@endforeach
					<tr>
						<th colspan="2" class="text-right">Total</th>
						<th>Rp {{ number_format($tot + $order->Ongkir,0,",",".") }}</th>
					</tr>
				</table>
			</div>
			<div class="row">
				<div class="col-sm-4 text-left text-sm">
					<b>ket :</b>
				</div>
				<div class="col-sm-4 text-center text-sm">
					<b>Penerima</b>
					<p class="mt-5" style="line-height:2px"><b>{{ $order->getKonsumen->Nama }}</b><br>____________________</p>
				</div>
				<div class="col-sm-4 text-right text-sm">
					<b>Mengetahui&nbsp;&nbsp;&nbsp;&nbsp;</b>
					<p class="mt-5">____________________</p>
				</div>
			</div>
		</div>
	</div>
@else
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body" wire:ignore.self>
            <table class="table" id="tbl">
                <thead>
                    <tr>
                        <th>Nama konsumen</th>
                        <th>Tanggal pesan</th>
                        <th>Tanggal kirim</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
	
	<script>
	function initTable()
	{
		$('#tbl').DataTable().destroy();
		$('#tbl').DataTable({
			ajax:"{{ route('cetak.nota') }}",
			columns:[
				{ data : 'get_konsumen.Nama' },
				{ data : 'TglPesan' },
				{ data : 'TglKirim' },
				{ 
					data  : 'IDOrder',
					render: function(data){
						return `
						<button class="btn text-primary" onClick="printing('${data}')">
							<i class="fa fa-print"></i>
						</button>`;
					}
				},
			]
		});
	}
	initTable();

	function printing(idItem)
	{
		if(idItem != '')
		{
			@this.call('Order', idItem);
		}
	}
	</script>
@endif
</div>