<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#brand-add">
                    <i class="fa fa-plus"></i>&nbsp;Tambah brand
                </button>
            </h1>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Branding Product</h1>
        </div>
        <div class="card-body">
            <table class="table" id="table-stok">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>panggilan</th>
                        <th>Tgl buat</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{ $row->Nama }}</td>
                        <td>{{ $row->ShortName }}</td>
                        <td>{{ $row->TglCreate }}</td>
                        <td>
                            <button class="btn text-secondary" wire:click="initEdit('{{ $row->IDBrand }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-danger" wire:click="initDel('{{ $row->IDBrand }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="brand-add" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Tambah branding</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="brand-add-nama" wire:model="nmAdd" />
                    </div>
                    <div class="form-group">
                        <label>nama pendekan</label>
                        <input type="text" class="form-control" id="brand-add-short" wire:model="shrtAdd" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="brand-edit" wire:ignore.self>
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
                        <label>nama pendekan</label>
                        <input type="text" class="form-control" wire:model="shrtEdit" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="update">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="brand-del" wire:ignore.self>
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
                        <label>Yakin ingin menghapus branding ini</label>
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
    $('#brand-add').modal('hide');
});
window.livewire.on('md-del',function(id){
    $('#brand-del').modal('show');
});
window.livewire.on('md-del-close',function(){
    $('#brand-del').modal('hide');
});
window.livewire.on('md-edit',function(){
    $('#brand-edit').modal('show');
});
window.livewire.on('md-edit-close',function(){
    $('#brand-edit').modal('hide');
});
</script>
</div>