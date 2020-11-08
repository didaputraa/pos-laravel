<?php
use Illuminate\Support\Facades\Storage;
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title d-inline">Produk</h5>&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-success d-inline" data-toggle="modal" data-target="#produk-add">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
        
            <table class="table" id="table-data" wire:ignore.self>
                <thead>
                    <th>Icon</th>
                    <th>Stok</th>
                    <th>Nama</th>
                    <th>Panggilan</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Brand</th>
                    <th>Harga</th>
                    <th>Opsi</th>
                </thead>
                <tbody>
				
                @foreach($table as $col)
                    <?php
                        $brg = $col->getStok->getBarang;
                        $jns = $col->getStok->getBarang->getjenis;
                        $stok= $col->getStok->StokKey == 0? 0 : round(($col->getStok->StokVal / $col->getStok->StokKey) * 100,2);
                    ?>
                    <tr>
                        <td><img src="{{ asset('storage/'.$col->Icon) }}" width="90px" height="90px" /></td>
                        <td>{{ $stok }}%</td>
                        <td>{{ $brg->Nama }}</td>
                        <td>{{ $brg->ShortName }}</td>
                        <td>{{ $jns->Nama }}</td>
                        <td>{{ $jns->getKategori->Nama }}</td>
                        <td>{{ $jns->getKategori->getBrand->Nama }}</td>
                        <td>{{ $col->HargaJual }}</td>
                        <td style="text-align:center">
                            <button class="btn btn-sm text-secondary" onClick="initUpdate('{{ $col->IDHarga }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm text-secondary" onClick="initConfig('{{ $col->IDHarga }}')">
                                <i class="fa fa-cog"></i>
                            </button>
                            <button class="btn btn-sm text-danger" onClick="initDel('{{ $col->IDHarga }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <?php
                    unset($brg, $jns);
                ?>
                </tbody>
            </table>
            
        </div>
    </div>

    <div class="modal mt-2" id="produk-add" data-backdrop="static">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
				<div class="card-header p-4">
					<h5 class="card-title">Tambah produk</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
				</div>
				<div class="card-body">
                    
                    <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control select2" id="brg-brand-select" onChange="getKategori()">
                            <option></option>
                            @foreach($table_brand as $r)
                            <option value="{{ $r->IDBrand }}">{{ $r->Nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" id="brg-kategori-select" onChange="getJenis()">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis</label>
                        <select class="form-control select2" id="brg-jenis-select" onChange="getBarang()">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barang</label>
                        <select class="form-control select2" id="brg-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" id="stok" />
                    </div>
                    <div class="form-group">
                        <label>pengurangan</label>
                        <input type="number" class="form-control" id="dsc" placeholder="pengurangan stok/pembelian" />
                    </div>
                </div>
                <div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendBarang()">S</button>
				</div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="produk-edit" data-backdrop="static">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ubah produk data umum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">

                    <div class="edit-type" id="edit-umum">
                        <div class="bg-secondary" style="height:100%"></div>
                        <input type="hidden" id="produk-edit-id" />
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Harga jual</label>
                                    <input type="number" id="produk-edit-hrg-jual" class="form-control" min="0" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Harga Beli</label>
                                    <input type="number" id="produk-edit-hrg-beli" class="form-control" min="0" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pengurangan</label>
                            <input type="number" class="form-control" id="produk-edit-dsc" min="0" placeholder="pengurangan stok/pembelian" />
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select class="form-control" id="e-jenis-select"></select>
                        </div>
                        @if($fiturs->barangEvt)
                        <div class="form-group">
                            <label>Event</label>
                            <select class="form-control" id="e-event-select"></select>
                        </div>
                        @endif
                    </div>

                </div>
                <div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendUpdate()">Update</button>
				</div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="modal-config" data-backdrop="static">
		<div class="container-fluid" style="max-width:500px">
			<div class="card card-danger">
				<div class="card-header p-4">
					<h1 class="card-title">Request extra</h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
				</div>
				<div class="card-body">
					<p>Mengkonfirmasi bahwa produk ini perlu di update lebih lanjut</p>
                    <textarea class="form-control" id="txtReq"></textarea>
					<input type="hidden" id="id_config"/>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendConfig()">Konfirmasi</button>
				</div>
			</div>
		</div>
	</div>

    <div class="modal mt-2" id="produk-del" data-backdrop="static">
		<div class="container-fluid" style="max-width:800px">
			<div class="card">
				<div class="card-header p-4">
					<h1 class="card-title">Hapus Produk</h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
				</div>
				<div class="card-body">
					<p>Yakin ingin menghapus data ini</p>
					<input type="hidden" id="del_id"/>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendDel()">Konfirmasi</button>
				</div>
			</div>
		</div>
	</div>

    <script>
    $('#table-data').DataTable();
    $('#brg-select,#brg-jenis-select,#brg-kategori-select,#brg-brand-select,#e-event-select,#e-jenis-select').select2({
        theme: 'bootstrap4'
    });
    var token = "{{ csrf_token() }}";


    function redirect_Barang()
    {
        Turbolinks.visit('product',{action:'replace'});
    }
    
    function getKategori()
    {
        let id = $('#brg-brand-select').val();

        if(id != '' || id != '-')
        {
            $.ajax({
                url: "{{ url('product/api/kategori') }}/"+id
            }).done(e=>{

                if(e.table.length > 0)
                {
                    $('#brg-kategori-select').empty();
                    $('#brg-kategori-select').append(`<option value="-">Silahkan pilih</option>`);

                    e.table.forEach(data=>{
                        $('#brg-kategori-select').append(`<option value="${data.IDBrgKategori}">${data.Nama}</option>`);
                    });
                }
                else
                {
                    $('#brg-kategori-select').empty();
                }
            }).fail(e=>{
                console.log('gagal mencari kategori');
            });
        }
    }

    function getJenis()
    {
        let id = $('#brg-kategori-select').val();
        
        if(id != '' || id != '-')
        {
            $.ajax({
                url: "{{ url('product/api/jenis') }}/"+id
            }).done(e=>{

                if(e.table.length > 0)
                {
                    $('#brg-jenis-select').empty();
                    $('#brg-jenis-select').append(`<option value="-">Silahkan pilih</option>`);

                    e.table.forEach(data=>{
                        $('#brg-jenis-select').append(`<option value="${data.IDBrgJenis}">${data.Nama}</option>`);
                    });
                }
                else
                {
                    $('#brg-jenis-select').empty();
                }
            });
        }
    }

    function getBarang()
    {
        let id = $('#brg-jenis-select').val();
        
        if(id != '' || id != '-')
        {
            $.ajax({
                url: "{{ url('product/api/barang') }}/"+id
            }).done(e=>{

                if(e.table.length > 0)
                {
                    $('#brg-select').empty();
                    $('#brg-select').append(`<option value="-">Silahkan pilih</option>`);

                    e.table.forEach(data=>{
                        $('#brg-select').append(`<option value="${data.IDBrg}">${data.Nama}</option>`);
                    });
                }
                else
                {
                    $('#brg-select').empty();
                }
            });
        }
    }

    function sendBarang()
    {
        $.ajax({
            url: "{{ route('produk.save') }}",
            method:'POST',
            data:{
                id_brg  : $('#brg-select').val(),
                stok    : $('#stok').val(),
                dsc     : $('#dsc').val()
            },
            headers:{
                'X-CSRF-TOKEN': token
            }
        }).done(()=>{
            
        });
    }

    function initUpdate(id)
    {
        var str = '';
        var evt = '';

        $('#produk-edit').modal('show');

        $.ajax({
            url:"{{ url('product/show') }}/"+id
        }).done(res2=>{

            if(res2.table.length > 0)
            {
                $('#produk-edit-id').val(res2.table[0].IDHarga);

                @if($fiturs->barangEvt)
                $.ajax({
                    url: "{{ route('produk.evt.all') }}"
                }).done(e =>{
                    e.table.forEach(row=>{

                        if(res2.table[0].IDBrgEvt == row.IDBrgEvt){
                            evt += `<option value="${row.IDBrgEvt}" selected>${row.Nama}</option>`;
                        }else{
                            evt += `<option value="${row.IDBrgEvt}">${row.Nama}</option>`;
                        }
                    });

                    $('#e-event-select').empty();
                    $('#e-event-select').append(evt);
                    evt = '';
                });
                @endif

                res2.table.forEach(row =>{
                    $('#produk-edit-hrg-jual').val(row.HargaJual);
                    $('#produk-edit-hrg-beli').val(row.HargaBeli);
                    $('#produk-edit-dsc').val(row.Dsc);
                });
                
                $.ajax({
                    url: "{{ route('produk.j.all') }}"
                }).done(e=>{
                    str = '';
                    e.table.forEach(row=>{
                        if(row.IDBrgJenis == res2.table[0].get_stok.get_barang.IDBrgJenis){
                            str += `<option value="${row.IDBrgJenis}" selected>${row.Nama}</option>`;
                        }else{
                            str += `<option value="${row.IDBrgJenis}">${row.Nama}</option>`;
                        }
                    });

                    $('#e-jenis-select').empty();
                    $('#e-jenis-select').append(str);
                    str = '';
                });
                
            }else{
                console.log('error show produk');
            }
        });
    }

    function sendUpdate()
    {
        $.ajax({
            url : "{{ route('produk.update') }}",
            method:'PUT',
            data:{
                id          : $('#produk-edit-id').val(),
                
                {!! $fiturs->barangEvt == 1? "event : $('#e-event-select').val()," : "" !!}

                jenis       : $('#e-jenis-select').val(),
                hargaJual   : $('#produk-edit-hrg-jual').val(),
                dsc         : $('#produk-edit-dsc').val()
            },
            headers:{
                'X-CSRF-TOKEN': token
            }
        }).done(() =>{
            redirect_Barang();
        }).fail(e =>{
            console.log('gagal update '+e);
        });
    }

    function initDel(id){
        $.ajax({
            url:"{{ url('product/show') }}/"+id
        }).done(res=>{

            if(res.table.length > 0)
            {
                $('#del_id').val(res.table[0].IDHarga);
                $('#produk-del').modal('show');
            }
        });
    }

    function sendDel(){
        $.ajax({
            url: "{{ route('produk.remove') }}/",
            method: 'DELETE',
            data:{
                id:$('#del_id').val()
            },
            headers:{
                'X-CSRF-TOKEN': token
            }
        }).done(()=>{
            redirect_Barang();
        }).fail((e)=>{
            console.log(e);
        });
    }

    function initConfig(idItem)
    {
        $('#id_config').val(idItem);
        $('#modal-config').modal('show');
    }

    function sendConfig()
    {
        let idItem = $('#id_config').val();

        if(idItem != '')
        {
            $.ajax({
                url     : "{{ route('produk.extra') }}",
                method  :'POST',
                data    : {
                    id  : idItem,
                    txt : $('#txtReq').val()
                },
                headers: {
                    'X-CSRF-TOKEN': token
                }
            }).done(evt =>{
                $('#id_config').val('');
                $('#modal-config').modal('hide');
            });
        }
    }

    $('#produk-add').on('hidden.bs.modal',function(){
        $('#brg-select').empty();
        $('#brg-jenis-select').empty();
        $('#brg-kategori-select').empty();
    });

    $('#produk-edit').on('hidden.bs.modal',function(){
        $('#produk-edit-id').val('');
    });

    $('#produk-del').on('hidden.bs.modal',function(){
        $('#del_id').val('');
    });
    
    </script>
</div>