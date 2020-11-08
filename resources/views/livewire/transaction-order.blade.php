<div class="col-lg-12">
@switch($btn_active)
    @case('order')
    <button class="btn btn-app text-success" wire:click="initSelect">
        <i class="fa fa-cart-plus"></i>
    </button>
    @break

    @case('barang')
    <button class="btn btn-app text-success" wire:click="initSelectBarang">
        <svg width="27px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" fill="#007BFF">
			<path d="M12.4375 0.1875L0 5.09375L0 18.53125L15 25.90625L26 18.53125L26 5.09375 Z M 12.46875 2.34375L23.6875 6.375L21.03125 7.78125L9.75 3.40625 Z M 7.03125 4.5L18.6875 9.03125L15.59375 10.65625L3.4375 5.90625 Z M 2.0625 6.4375L15 11.5L15 23.5L14.84375 23.59375L2 17.28125L2 6.46875 Z M 6.5 10.65625L5.03125 12.5625L6 12.875L6 15.625L7 16L7 13.21875L8 13.53125 Z M 10.5 12.03125L9 13.96875L10 14.3125L10 17.34375L11 17.71875L11 14.65625L11.96875 14.96875 Z M 5 16.03125L5 17.25L12 20.5625L12 19.3125Z" fill="#007BFF" />
		</svg>
    </button>
    @break;

@endswitch

    <div class="card">
        <div class="card-body">
            @switch($page_active)

            @case('order')
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h3>{{ $customer_name }}</h3>
                </div>
                <div class="col-lg-6">
                    <h5 class="text-right pt-2">5-Juli-2020</h5>
                </div>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @if(empty($table_item))
                    <tr>
                        <td colspan="5" class="p-4 text-center">
                            <p>{{ $customer_name != ''? 'Belum ada barang yg di pesan' : 'Belum ada orderan' }}</p>
                        </td>
                    </tr>
                @else
                    @foreach($table_item as $i)
                        <tr>
                            <td><img src="{!! asset('storage/'.$i->getHarga->Icon) !!}" height="70px" width="70px"/></td>
                            <td class="align-middle">{{ $i->getHarga->getStok->getBarang->getJenis->Nama }}</td>
                            <td class="align-middle">{{ $i->Jumlah }}</td>
                            <td class="align-middle">{{ $i->Harga }}</td>
                            <td class="align-middle">
                                <button class="btn btn-sm text-secondary" wire:click="initUpdateItem('{{ $i->IDOItem }}')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm text-danger" onClick="initRemoveItem('{{ $i->IDOItem }}')">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @php 
                        $total += ($i->Harga * $i->Jumlah);
                        @endphp
                    @endforeach
                @endif
                </tbody>
            </table>

            <div class="row mt-5">
                
                <div class="col-lg-6">
                    @if($fiturs->Deadline)
                    <div class="form-group">
                        <label>Deadline</label>
                        <input type="date" class="form-control" wire:model="deadline"/>
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-6">
                @if($fiturs->ekspedisi)
                    <div class="form-group">
                        <label>Ekspedisi</label>
                        <select class="form-control" wire:model="ekspedisi" wire:change="changeOngkir">
                            @foreach($ekspedisis as $i)
                                <option value="{{ $i->IDEkspedisi }}">{{ $i->Nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-6"></div>

                <div class="col-lg-6">
                    <input type="hidden" id="total-brg" value="{{ $total }}" readonly />
                    <table class="table border">
                        <tbody>
                            <tr>
                                <th>Ongkir</th>
                                <td>:</td>
                                <td><input type="number" class="form-control" id="ongkir" min="0" value="0" wire:model="ongkir" /></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>:</td>
                                <td><input type="text" id="total" value="100" class="form-control border-0" readonly /></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-right">
                        <button class="btn btn-lg btn-outline-primary" onClick="initBatal()">Batalkan</button>
                        <button class="btn btn-lg btn-outline-primary" onClick="initKirim()">Proses</button>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-init-del-item" wire:ignore.self>
                <div class="container-fluid mt-5" style="max-width:500px">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Konfirmasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Konfirmasi penghapusan item order</label>
                                <input type="hidden" wire:model="item_remove" />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-outline-primary float-right" wire:click="removeItem">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-init-update-item" wire:ignore.self>
                <div class="container-fluid mt-5" style="max-width:500px">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Ubah jumlah item barang</label>
                                <input type="number" min="1" class="form-control" wire:model="jumlah" />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-outline-primary float-right" wire:click="initItemUpdate">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-init-pembayaran" wire:ignore.self>
                <div class="container-fluid mt-5" style="max-width:500px">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Konfirmasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Konfirmasi penjualan</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-outline-primary float-right" wire:click="sendOrder">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-init-pembatalan" wire:ignore.self>
                <div class="container-fluid mt-5" style="max-width:500px">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Konfirmasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Konfirmasi pembatalan penjualan</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-outline-primary float-right" wire:click="cancelOrder">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>

            function sumtotal()
            {
                var ongkir  = $('#ongkir'),
                    tbrg    = $('#total-brg');
                
                var total   = Number(ongkir.val()) + Number(tbrg.val());

                $('#total').val(total);
            }

            function initBatal()
            {
                if(@this.get('orderCancel') != '')
                {
                    $('#modal-init-pembatalan').modal('show');
                }
            }

            function initKirim()
            {
                if(@this.get('orderCancel') != '')
                {
                    $("#modal-init-pembayaran").modal('show');
                }
            }

            sumtotal();

            $('#ongkir').on('change',function(evt){
                sumtotal();
            });

            </script>
            @break

            @case('select-customer')
            <div class="d-block mb-3">
                <button class="btn btn-outline-secondary" wire:click="backOrder">Batal</button>
            </div>
                <table class="table" id="tbl-cus" >
                <thead>
                    <tr>
                        <th>Nama {{ $customer_name }}</th>
                        <th>Gender</th>
                        <th>No telp</th>
                        <th>Email</th>
                        <th>Opsi</th>
                    </tr>
                </thead>

                </table>
            <script>
                 $('#tbl-cus').DataTable({
                    ajax : "{{ url('konsumen/api/all') }}",
                    columns:[
                        { "data": "Nama" },
                        { "data": "Gender" },
                        { "data": "NoTelp" },
                        { "data": "Email" },
                        { 
                            "data": 'IDKonsumen',
                            render:function(data){
                                return `
                                    <button class="btn btn-outline-primary" onClick="selectCustomer('${data}')">Pilih</button>
                                `;
                            }
                        }
                    ]
                });
            </script>
            @break


            @case('barang')
            <div class="d-block mb-3">
                <button class="btn btn-outline-secondary" wire:click="backOrder('barang')">Selesai</button>
            </div>
                <table class="table" id="tbl-brg" wire:ignore>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Brand</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>

                <div class="modal" id="modal-jml" wire:ignore.self>
                    <div class="container-fluid" style="max-width:500px">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Konfirmasi</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Masukkan jumlah</label>
                                    <input type="number" id="jumlah" min="1" max="{{ $maxInputJml }}" value="1" class="form-control"/>
                                    <input type="hidden" id="idHarga" wire:model="hargaID"/>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                                <button class="btn btn-outline-primary float-right" onClick="selectBarang()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function initTable()
                    {
                        $('#tbl-brg').DataTable().destroy();
                        $('#tbl-brg').DataTable({
                            ajax    : "{{ route('produk.all') }}",
                            columns : [
                                {
                                    "data"   : "Icon",
                                    "render" : function(data){
                                        return `<img src="{{ asset('storage') }}/${data}" width="85px" height="85px" />`;
                                    }
                                },
                                {"data" : "Nama"},
                                {"data" : "HargaJual"},
                                {"data" : "jenis"},
                                {"data" : "kategori"},
                                {"data" : "brand"},
                                {
                                    "data"  : "IDHarga",
                                    "render": function(data){
                                        return `
                                            <button class="btn btn-outline-primary" onClick="initBarang('${data}')">Pilih</button>
                                        `;
                                    }
                                },
                            ],
                            responsive  : true,
                            retrieve    : true,
                            searching   : true,
                            paging      : true,
                            deferRender : true,
                            error       : function(err){
                                console.log(err)
                            }
                        });
                    }

                    initTable();

                    $('#modal-jml').on('hidden.bs.modal',function(){
                        @this.call('render');
                        initTable();
                    });
					window.livewire.on('close-select-barang',function(){
						$('#modal-jml').modal('hide');
						@this.call('render');
						initTable();
					});
                </script>
            @break;

            @endswitch
        </div>
    </div>

	<div class="modal" id="modal-err" data-backdrop="static" wire:ignore.self>
		<div class="container-fluid" style="max-width:500px">
			<div class="card card-warning">
				<div class="card-header">
					<p class="card-title">Terdapat error / bug</p>
				</div>
				<div class="card-body">
					Mohon Refresh halaman ini
				</div>
			</div>
		</div>
	</div>
	
	<script>

	window.livewire.on('close-del-item',function(){
		$('#modal-init-del-item').modal('hide');
		sumtotal();
	});

	window.livewire.on('show-modal-item-update',function(){
		$('#modal-init-update-item').modal('show');
	});

	window.livewire.on('close-modal-item-update',function(){
		$('#modal-init-update-item').modal('hide');
		sumtotal();
	});

	window.livewire.on('close-pembayaran',function(){
		$('#modal-init-pembayaran').modal('hide');
		$('body').scrollTop(0);
		sumtotal();
		
		Turbolinks.visit("{{ url('/pembayaran') }}",{action: 'replace'});
	});

	window.livewire.on('close-pembatalan',function(){
		$('#modal-init-pembatalan').modal('hide');
		$('body').scrollTop(0);
		sumtotal();
	});

	window.livewire.on('err-terjadi',function()
	{
		console.log(@this.get('errMsg'));
		
		$('#modal-err').modal('show');
	});


	function selectCustomer(idItem)
	{
		var component = window.livewire.find("{{ $_instance->id }}");
			component.call('selectCustomer',idItem);
	}

	function selectBarang()
	{
		let jml = $('#jumlah').val();
		let hrg = @this.get('hargaID');

		@this.call('initBarang',jml, hrg);
	   
	}

	function initBarang(idItem)
	{
		if(idItem != '')
		{
			@this.set('hargaID',idItem);
			@this.call('setMaxInput',idItem);

			$('#modal-jml').modal('show');
		}
	}

	function initRemoveItem(idItem = ''){
		if(idItem != '')
		{
			@this.set('item_remove',idItem)
			$('#modal-init-del-item').modal('show');
		}
	}

	$('#modal-init-del-item').on('hidden.modal.bs',function(){
		@this.set('item_remove','');
		sumtotal();
	});
	</script>

</div>