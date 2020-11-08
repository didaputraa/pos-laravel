<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#jenis-add">
                    <i class="fa fa-plus"></i>&nbsp;Tambah jenis barang
                </button>
            </h1>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Jenis Product</h1>
        </div>
        <div class="card-body">
            <table class="table" id="table-stok">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>kategori</th>
                        <th>Brand</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{ $row->Nama }}</td>
                        <td>{{ $row->getKategori->Nama }}</td>
                        <td>{{ $row->getKategori->getBrand->Nama }}</td>
                        <td>
                            <button class="btn text-secondary" wire:click="initEdit('{{ $row->IDBrgJenis }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-danger" wire:click="initDel('{{ $row->IDBrgJenis }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="jenis-add" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Tambah Jenis product</h1>
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
                        <select class="form-control" wire:model="brandAdd" wire:change="initBrand">
                        <option value="0">--- pilih ---</option>
                        @foreach($table_brand as $row)
                            <option value="{{ $row->IDBrand }}">{{ $row->Nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" wire:model="kategoriAdd">
                        @foreach($table_kategori as $row)
                            <option value="{{ $row['IDBrgKategori'] }}">{{ $row['Nama'] }}</option>
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

    <div class="modal mt-2" id="jenis-edit" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Update branding</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model="nmEdit" />
                        <input type="hidden" wire:model="idEdit" />
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control" wire:model="brandEdit" wire:change="initBrandEdit">
                        @foreach($table_brand_edit as $row)
                            <option value="{{ $row->IDBrand }}">{{ $row->Nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" wire:model="kategoriEdit">
                        @foreach($table_kategori_edit as $row)
                            <option value="{{ $row['IDBrgKategori'] }}">{{ $row['Nama'] }}</option>
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

    <div class="modal mt-2" id="jenis-del" wire:ignore.self>
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
                        <label>Yakin ingin menghapus jenis product ini</label>
                        <input type="hidden" wire:model="idDel" />
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
window.livewire.on('md-add-close',function(){
    $('#jenis-add').modal('hide');
});
window.livewire.on('md-edit',function(){
    $('#jenis-edit').modal('show');
});
window.livewire.on('md-edit-close',function(){
    $('#jenis-edit').modal('hide');
});
window.livewire.on('md-del',function(){
    $('#jenis-del').modal('show');
});
window.livewire.on('md-del-close',function(){
    $('#jenis-del').modal('hide');
});
</script>
</div>