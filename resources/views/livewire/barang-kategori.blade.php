<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#kategori-add">
                    <i class="fa fa-plus"></i>&nbsp;Tambah kategori barang
                </button>
            </h1>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Kategori Product</h1>
        </div>
        <div class="card-body" wire:ignore>
            <table class="table" id="table-kategori">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{ $row->Nama }}</td>
                        <td>{{ $row->getBrand->Nama }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm text-secondary" wire:click="initEdit('{{ $row->IDBrgKategori }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm text-danger" wire:click="initDel('{{ $row->IDBrgKategori }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="kategori-add" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Tambah kategori product</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model="nmAdd" />
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control" wire:model="brandAdd">
                        <option value="0">--- pilih ---</option>
                        @foreach($table_brand as $row)
                            <option value="{{ $row->IDBrand }}">{{ $row->Nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="kategori-edit" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Update kategori product</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model="nmEdit" />
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control" wire:model="brandEdit">
                        <option value="0">--- pilih ---</option>
                        @foreach($table_brand as $row)
                            <option value="{{ $row->IDBrand }}">{{ $row->Nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="update">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="kategori-del" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Konfirmasi</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Konfirmasi penghapusan kategori product</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="remove">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

<script>
$('#table-kategori').DataTable();


window.livewire.on('md-add-close',function(){
    $('#kategori-add').modal('hide');
    Turbolinks.visit(baseURL+'/product/kategori',{action:'replace'});
});

window.livewire.on('md-edit',function(){
    $('#kategori-edit').modal('show');
});

window.livewire.on('md-edit-close',function(){
    $('#kategori-edit').modal('hide');
    Turbolinks.visit(baseURL+'/product/kategori',{action:'replace'});
});

window.livewire.on('md-del',function(){
    $('#kategori-del').modal('show');
});

window.livewire.on('md-del-close',function(){
    $('#kategori-del').modal('hide');
    Turbolinks.visit(baseURL+'/product/kategori',{action:'replace'});
});
</script>
</div>