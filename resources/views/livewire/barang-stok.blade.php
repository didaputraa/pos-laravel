<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Data Stok Product</h1>
        </div>
        <div class="card-body" wire:ignore.self>
            <table class="table" id="table-stok">
                <thead>
                    <tr>
                        <th>Nama barang</th>
                        <th>Stok Awal</th>
                        <th>Stok Akhir</th>
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                <tr>
                    <td>{{ $row->getStok->getBarang->Nama }}</td>
                    <td>{{ $row->getStok->StokKey }}</td>
                    <td>{{ $row->getStok->StokVal }}</td>
                    <td>{{ $row->getStok->getBarang->getJenis->getKategori->getBrand->Nama }}</td>
                    <td>{{ $row->getStok->getBarang->getJenis->getKategori->Nama }}</td>
                    <td>{{ $row->getStok->getBarang->getJenis->Nama }}</td>
                    <td>
                        <button class="btn text-secondary" wire:click="initEdit('{{ $row->IDStok }}')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn text-secondary" wire:click="initRequestStok('{{ $row->IDHarga }}')">
                            <i class="fa fa-cog"></i>
                        </button>
                        <button class="btn text-danger" wire:click="initDel('{{ $row->IDStok }}')">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal mt-2" id="stok-edit" wire:ignore.self>
            <div class="container-fluid" style="max-width:1000px">
                <div class="card">
                    <div class="card-header p-4">
                        <h1 class="card-title">Edit Stok Product</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-grop">
                            <label>Stok Awal</label>
                            <input type="hidden" wire:model="item" />
                            <input type="number" class="form-control" wire:model="stokAwal" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-grop">
                            <label>Stok Akhir</label>
                            <input type="number" class="form-control" wire:model="stokAkhir"/>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-outline-primary float-right" wire:click="update">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal mt-2" id="stok-del" wire:ignore.self>
            <div class="container-fluid" style="max-width:800px">
                <div class="card">
                    <div class="card-header p-3">
                        <h1 class="card-title">Konfirmasi</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="card-body">
                        Stok product ini akan dikosongkan
                        <input type="hidden" wire:model="item_del" />
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-outline-primary float-right" wire:click="delete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal mt-2" id="stok-del" data-backdrop="static" wire:ignore.self>
            <div class="container-fluid" style="max-width:800px">
                <div class="card">
                    <div class="card-header p-3">
                        <h1 class="card-title">Konfirmasi</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="card-body">
                        Stok product ini akan dikosongkan
                        <input type="hidden" wire:model="item_del" />
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-outline-primary float-right" wire:click="delete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal mt-2" id="stok-req" data-backdrop="static" wire:ignore.self>
            <div class="container-fluid" style="max-width:800px">
                <div class="card">
                    <div class="card-header p-3">
                        <h1 class="card-title">Konfirmasi</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="card-body">
                        Konfirmasi stok ini akan ada penambahan
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-outline-primary float-right" wire:click="prosesRequest">Proses</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

<script>
$('#table-stok').DataTable();

window.livewire.on('modal-edit',function(){
    $('#stok-edit').modal('show');
});
window.livewire.on('modal-edit-close',function(){
    $('#stok-edit').modal('hide');
    $('#table-stok').DataTable();
});
window.livewire.on('modal-del',function(){
    $('#stok-del').modal('show');
});
window.livewire.on('modal-del-close',function(){
    $('#stok-del').modal('hide');
});
window.livewire.on('show-request-extra',function(){
    $('#stok-req').modal('show');
});
window.livewire.on('close-request-extra',function(){
    $('#stok-req').modal('hide');
    @this.set('item',null);
});
$('#stok-req').on('hidden.bs.modal',function(){
    $('#table-stok').DataTable();
});
</script>
</div>
