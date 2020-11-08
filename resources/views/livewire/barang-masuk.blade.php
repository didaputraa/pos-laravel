<div class="col-lg-12">
@switch($pageActive)
    @case('input')
    <button class="btn btn-primary mb-3" wire:click="switchTo('view')">Lihat Data barang masuk</button>
    <div class="card">
        <div class="card-header">
            <p class="card-title">Barang masuk</p>
        </div>
        <form>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" wire:model="nama" />
                            @error('nama')
                                <p class="text-danger text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Short name</label>
                            <input type="text" class="form-control" wire:model="shrNama" />
                            @error('shrNama')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="Number" class="form-control" wire:model="stok"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Icon barang</label>
                                <div class="input-group">
                                    <div class="custom-file" wire:ignore>
                                        <input type="file" class="custom-file-input" id="exampleInputFile" wire:model="photo">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            @error('photo')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Brand</label>
                            <div wire:ignore>
                                <select class="form-control select2" id="brand" onChange="getKategori()">
                                    <option>--- silahkan pilih --- </option>
                                    @foreach($tbl_data as $r)

                                        <option value="{{ $r->IDBrand }}">{{ $r->Nama }}</option>

                                    @endforeach
                                </select>
                            </div>
                            @error('brand')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <div wire:ignore>
                                <select class="form-control select2" id="kategori" onChange="getJenis()" ></select>
                            </div>
                            @error('kategori')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <div wire:ignore>
                                <select class="form-control select2" id="jenis" onChange="initJenis()"></select>
                            </div>
                            @error('jenis')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" wire:click.prevent="StoreBarang" class="btn btn-outline-primary float-right">Simpan</button>
            </div>
        </form>

    </div>
    <script>
    function getKategori()
    {
        let item_brand = $('#brand').val();

        if(item_brand != '')
        {
            $.ajax({
                url: '{{ url("product/api/kategori") }}/'+ item_brand
            }).done(evt=>{

                $('#kategori').empty();

                if(evt.table.length > 0)
                {
                    $('#kategori').append(`<option>--- silahkan pilih --- </option>`);

                    evt.table.forEach( e=>{
                        $('#kategori').append(`<option value="${e.IDBrgKategori}">${e.Nama}</option>`);
                    });
                }
            });
            @this.set('brand', item_brand);
        }
    }

    function getJenis()
    {
        let item_id = $('#kategori').val();

        $.ajax({
            url: '{{ url("product/api/jenis") }}/'+ item_id
        }).done(evt=>{

            $('#jenis').empty();

            if(evt.table.length > 0)
            {
                $('#jenis').append(`<option>--- silahkan pilih --- </option>`);

                evt.table.forEach( e=>{
                    $('#jenis').append(`<option value="${e.IDBrgJenis}">${e.Nama}</option>`);
                });
            }
        });

        @this.set('kategori', item_id);
    }

    function initJenis()
    {
        let item_id = $('#jenis').val();

        if(item_id != '')
        {
            @this.set('jenis', item_id);
        }
    }

    bsCustomFileInput.init();
    $('.select2').select2({ theme: 'bootstrap4'});
    
    </script>
    @break

    @case('view')
    <button class="btn btn-success mb-3" wire:click="switchTo('input')">Input barang masuk</button>
    <div class="card" wire:ignore.self>
        <div class="card-header">
            <p class="card-title">Barang masuk</p>
        </div>
        <div class="card-body">
            <table class="table" id="tbl">
                <thead>
                    <tr>
                        <th>Nama barang</th>
                        <th>Tgl masuk</th>
                        <th>Jumlah Stok</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="modal-confirm" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid" style="max-width:450px">
            <div class="card">
                <div class="card-header p-4">
                    <h1 class="card-title">Konfirmasi</h1>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <p>Konfirmasi penghapusan barang masuk</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="hapus">proses</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
window.livewire.on('close-hapus',function(){
    $('#modal-confirm').modal('hide');
    Turbolinks.visit('{{ url()->current() }}?act=view', {action:'replace'});
});

function initTable()
{
    $('#tbl').DataTable({
        data: {!! json_encode($tbl_data) !!},
        columns:[
            {'data' : 'get_harga.get_stok.get_barang.Nama'},
            {'data' : 'TglMasuk'},
            {'data' : 'Jumlah'},
            {
                'data' : 'IDBrgMasuk',
                render : function(data){
                    return `
                        <button class='btn text-danger' onClick="initHapus('${data}')">
                            <i class='fa fa-trash-alt'></i>
                        </button>
                    `;
                }
            }
        ]
    });
}
initTable();

function initHapus(idItem)
{
    if(idItem != '')
    {
        @this.set('idItem', idItem);
        $('#modal-confirm').modal('show');
    }
}

$('#modal-confirm').on('hidden.bs.modal',function(){
    Turbolinks.visit('{{ url()->current() }}?act=view', {action:'replace'});
});
</script>
    @break

@endswitch
</div>