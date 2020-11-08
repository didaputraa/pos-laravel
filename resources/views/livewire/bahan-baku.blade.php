<div class="col-lg-12">
    <div class="card">
		<div class="card-header">
            <h5 class="card-title">Bahan baku</h5>
        </div>
    </div>
	<div class="card">
		<div class="card-header">
            <h5 class="card-title">
                <button class="btn btn-outline-success" wire:click="$emit('modal-add')"><i class="fa fa-plus"></i> Tambah</button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Biaya</th>
                        <th>Biaya tambahan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>
                            {{ $row->Label }}
                            <input type="hidden" id="labels-{{ $row->IDBPR }}" value="{{ $row->Label }}" readonly />
                        </td>
                        <td>
                            {{ $row->Biaya }}
                            <input type="hidden" id="biaya-{{ $row->IDBPR }}" value="{{ $row->Biaya }}" readonly />
                        </td>
                        <td>
                            {{ $row->BiayaLain }}
                            <input type="hidden" id="biayaLain-{{ $row->IDBPR }}" value="{{ $row->BiayaLain }}" readonly />
                        </td>
                        <td>
                            <input type="hidden" id="rincianItem-{{ $row->IDBPR }}" value='{{ $row->RincianItem }}' readonly />
                            <button class="btn btn-sm" onClick="initEditBaku('{{ $row->IDBPR }}')">
                                <i class="fa fa-pen"></i>
                            </button>
                            <button class="btn btn-sm text-primary">
                                <i class="fa fa-eye" wire:click="$emit('view-resep','{{ $row->IDBPR }}')"></i>
                            </button>
                            <button class="btn btn-sm text-danger" onClick="initResepDel('{{ $row->IDBPR }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(is_array($table))
            <div class="float-right">
                <ul class="pagination">
                    <li class="page-item active"><a href="javascript:" class="page-link">1</a></li>
                    <li class="page-item"><a href="javascript:" class="page-link">2</a></li>
                </ul>
            </div>
            @endif
        </div>
        <div class="card-footer">
            
        </div>
    </div>

    <div class="modal" id="resep-add">
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
				<div class="card-header p-4">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="add-label" id="label-add" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" name="biaya" value="0" id="biaya-add" class="form-control" min="0" />
                    </div>
                    <div class="form-group">
                        <label>Biaya lain</label>
                        <input type="number" name="biaya_lain" value="0" id="biaya_lain-add" class="form-control" min="0" />
                    </div>
                </div>
                <div class="card-footer">
					<button class="btn btn-outline-secondary">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendInsert()">Simpan</button>
				</div>
            </div>
        </div>
    </div>

    <div class="modal" id="resep-view" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
				<div class="card-header p-4">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <input type="hidden" id="resep-view-id" />
                    <div class="form-group">
                        <label>Label nama</label>
                        <input type="text" id="resep-view-label_nama" readonly class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Item</label> 
                        <button class="btn" onClick="initItemEdit()">
                            <i class="fa fa-edit"></i>
                        </button>
                        <table class="table" id="resep-view-item_table"></table>
                    </div>
                    <div class="float-right">
                        <table>
                            <tr>
                                <th>Biaya lain</th>
                                <td>:</td>
                                <td id="resep-view-biaya_lain">0</td>
                            </tr>
                            <tr>
                                <th>Total biaya</th>
                                <td>:</td>
                                <td id="resep-view-total_biaya">0</td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
				</div>
            </div>
         </div>
    </div>

    <div class="modal" id="resep-edit" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
				<div class="card-header p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama label</label>
                        <input type="hidden" id="resep-edit-id" />
                        <input type="text" class="form-control" id="resep-edit-label" />
                    </div>
                    <div class="form-group">
                        <label>Biaya lainnya</label>
                        <input type="number" min="0" class="form-control" id="resep-edit-biayaLain" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" onClick="sendUpdateBaku()">Update</button>
                </div>
            </div>
        </div>
     </div>

    <div class="modal mt-5" id="resep-item-del">
        <div class="container-fluid" style="max-width:700px">
            <div class="card card-danger">
				<div class="card-header p-3">
                    <h2 class="card-title">Konfirmasi hapus item</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    Ingin hapus data item ini
                    <input type="hidden" id="resep-item-del-id" />
                </div>
                <div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendItemDel()">Konfirmasi</button>
				</div>
            </div>
        </div>
    </div>

    <div class="modal mt-5" id="resep-del">
        <div class="container-fluid" style="max-width:700px">
            <div class="card card-danger">
				<div class="card-header p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    Konfirmasi penghapusan item
                    <input type="hidden" id="resep-del-id" />
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendResepDel()">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function get_bahanBaku()
        {
            Turbolinks.visit('bahan-baku',{action:'replace'});
        }

        var xtoken = "{{ csrf_token() }}";
        window.livewire.on('modal-add',function(){
            $('#resep-add').modal('show');
        });
        window.livewire.on('modal-close',function(){
            $('#resep-add').modal('hide');
        });
        window.livewire.on('view-resep',function(id){

            var json_item = $('#rincianItem-'+id).val();
            var json      = '';
            var tot       = 0, total = 0;

            $('#resep-view-item_table').empty();

            if(json_item != '-' && json_item != '')
            {
                json = JSON.parse(json_item);

                $('#resep-view-item_table').append(`
                    <thead class="thead-dark">
                        <tr>
                            <th>nama item</th>
                            <th>Harga</th>
                            <th>opsi</th>
                        </tr>
                    </thead>`);

                    (Object.keys(json)).forEach(es=>
                    {
                        let e = json[es];
                        $('#resep-view-item_table').append(`
                            <tr>
                                <td>${e.label}</td>
                                <td>${Number(e.biaya).toLocaleString()}</td>
                                <td width="8%">
                                    <button class="btn text-danger" onClick="initItemDel(${e.id})">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                        tot += Number(e.biaya);
                    });
                
                $('#resep-view-item_table').append(`
                    <tr>
                        <th style="text-align:right">Total</th>
                        <td colspan="2">${tot.toLocaleString()}</td></td>
                    </tr>
                `);
            }

            $('#resep-view-id').val(id);
            $('#resep-view-label_nama').val($('#labels-'+id).val());

            $('#resep-view-biaya_lain').empty();
            $('#resep-view-biaya_lain').append(Number($('#biayaLain-'+id).val()).toLocaleString());
           
            total = tot + Number($('#biayaLain-'+id).val());

            $('#resep-view-total_biaya').empty();
            $('#resep-view-total_biaya').append(total.toLocaleString());

            $('#resep-view').modal('show');
        });

        function sendInsert(){
            $.ajax({
                url:"{{ route('baku.add') }}",
                method:'POST',
                data:{
                    label:$('#label-add').val(),
                    biaya:$('#biaya-add').val(),
                    biaya_lain:$('#biaya_lain-add').val(),
                },
                headers:{
                    'X-CSRF-TOKEN': xtoken
                }
            }).done(e=>{
                get_bahanBaku();
            }).fail(e=>{
                console.log('gagal '+e);
            });
        }

        function initItemDel(id){
            $('#resep-item-del-id').val(id);
            $('#resep-item-del').modal('show');
        }

        function sendItemDel(){
            $.ajax({
                url:"{{ route('baku.remove-item') }}",
                method:'DELETE',
                data:{
                    id: $('#resep-view-id').val(),
                    idItem: $('#resep-item-del-id').val()
                },
                headers:{
                    'X-CSRF-TOKEN':xtoken
                }
            }).done(e=>{
                get_bahanBaku();
            });
        }

        function initItemEdit()
        {
            let id = $('#resep-view-id').val();
            
            if(id != '')
            {
                Turbolinks.visit('bahan-baku-item-edit/'+id, {action:'replace'});
            }
        }

        function initEditBaku(id)
        {
            if(id != '')
            {
                $('#resep-edit-id').val(id);
                $('#resep-edit-label').val($('#labels-'+id).val());
                $('#resep-edit-biayaLain').val($('#biayaLain-'+id).val());

                $('#resep-edit').modal('show');
            }
        }

        function sendUpdateBaku()
        {
            $.ajax({
                url: "{{ route('baku.update') }}",
                data:{
                    id       : $('#resep-edit-id').val(),
                    label    : $('#resep-edit-label').val(),
                    biayaLain: $('#resep-edit-biayaLain').val()
                },
                method:'PUT',
                headers:{
                    'X-CSRF-TOKEN': xtoken
                }
            }).done(e=>{
                get_bahanBaku();
            }).fail(e=>{
                console.log('edit bahan baku gagal '+e);
            });
        }

        function initResepDel(id)
        {
            $('#resep-del-id').val(id);
            $('#resep-del').modal('show');
        }

        function sendResepDel()
        {
            let id = $('#resep-del-id').val();

            if(id != '')
            {
                $.ajax({
                    url:"{{ route('baku.remove') }}",
                    method:"DELETE",
                    data:{
                        item: id
                    },
                    headers:{
                        'X-CSRF-TOKEN': xtoken
                    }
                }).done(e=>{
                    get_bahanBaku();
                });
            }
        }

        $('#resep-edit').on('hidden.bs.modal',function(){
            $('#resep-edit-id').val('');
            $('#resep-edit-label').val('');
            $('#resep-edit-biayaLain').val('');
        });
        $('#resep-del').on('hidden.bs.modal',function(){
            $('#resep-del-id').val('');
        });
    </script>
</div>