<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ekspedisi</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><button class="btn btn-outline-success" wire:click="initAdd()"><i class="fa fa-plus"></i>&nbsp;Tambah</button></h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tarif</th>
                        <th width="12%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{ $row->Nama }}</td>
                        <td>{{ $row->Tarif }}</td>
                        <td>
                            <button class="btn btn-sm text-secondary" wire:click="initEdit('{{ $row->IDEkspedisi }}')">
							    <i class="fa fa-edit"></i>
						    </button>
						    <button class="btn btn-sm text-danger" wire:click="initDel('{{ $row->IDEkspedisi }}')">
							    <i class="fa fa-trash-alt"></i>
						    </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="ekspedisi-add" wire:ignore.self>
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tambah data ekspedisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Ekspedisi</label>
                        <input type="text" class="form-control" id="ekspedisi-nama" wire:model="nama_add" />
                    </div>
                    <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" class="form-control" id="ekspedisi-tarif" wire:model="tarif_add" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" wire:click='store()'>Simpan</button>
                </div>
            </div>
         </div>
    </div>

    <div class="modal mt-2" id="ekspedisi-edit" wire:ignore.self>
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ubah data ekspedisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Ekspedisi</label>
                        <input type="hidden" wire:model="id_edit" />
                        <input type="text" class="form-control" id="ekspedisi-edit-nama"  wire:model="nama_edit" />
                    </div>
                    <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" class="form-control" id="ekspedisi-edit-tarif" wire:model="tarif_edit" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" wire:click="update">Update</button>
                </div>
            </div>
         </div>
    </div>

    <div class="modal mt-2" id="ekspedisi-del" wire:ignore.self>
		<div class="container-fluid" style="max-width:800px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Konfirmasi penghapusan data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    Yakin ingin menghapus data ekspedisi ini
                    <input type="hidden" model:model="id_del" />
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" wire:click="delete">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

<script>
window.livewire.on('modal-add',function(){
    $('#ekspedisi-add').modal('show');
});
window.livewire.on('modal-add-success',function(){
    $('#ekspedisi-add').modal('hide');
});
window.livewire.on('modal-edit',function(){
    $('#ekspedisi-edit').modal('show');
});
window.livewire.on('modal-edit-success',function(){
    $('#ekspedisi-edit').modal('hide');
});
window.livewire.on('modal-init-del',function(){
    $('#ekspedisi-del').modal('show');
});
window.livewire.on('modal-success-del',function(){
    $('#ekspedisi-del').modal('hide');
});
</script>
</div>
