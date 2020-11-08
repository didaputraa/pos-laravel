<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#event-add">
                    <i class="fa fa-plus"></i>&nbsp;Tambah Event
                </button>
            </h1>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Event Product</h1>
        </div>
        <div class="card-body">
            <table class="table" id="table-event">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tgl mulai</th>
                        <th>Tgl selesai</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{ $row->Nama }}</td>
                        <td>{{ $row->TglMulai }}</td>
                        <td>{{ $row->TglSelesai }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm text-secondary" wire:click="initEdit('{{ $row->IDBrgEvt }}')">
							    <i class="fa fa-edit"></i>
						    </button>
						    <button class="btn btn-sm text-danger" wire:click="initDel('{{ $row->IDBrgEvt }}')">
							    <i class="fa fa-trash-alt"></i>
						    </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="event-add" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Tambah event product</h1>
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
                        <label>Mulai</label>
                        <input type="date" class="form-control" wire:model="tglStart_add" />
                    </div>
                    <div class="form-group">
                        <label>Selesai</label>
                        <input type="date" class="form-control" wire:model="tglEnd_add" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="event-edit" wire:ignore.self>
        <div class="container-fluid" style="max-width:1000px">
            <div class="card">
                <div class="card-header p-3">
                    <h1 class="card-title">Update event</h1>
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
                        <label>Mulai</label>
                        <input type="date" class="form-control" wire:model="tglStart_edit" />
                    </div>
                    <div class="form-group">
                        <label>Selesai</label>
                        <input type="date" class="form-control" wire:model="tglEnd_edit" />
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" wire:model="statusEvt"/>
                            <label class="custom-control-label" for="status">Status</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="update">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal mt-2" id="event-del" wire:ignore.self>
		<div class="container-fluid" style="max-width:800px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Konfirmasi penghapusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    Yakin ingin menghapus event ini
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
    $('#event-add').modal('hide');
});

window.livewire.on('md-edit',function(){
    $('#event-edit').modal('show');
});
window.livewire.on('md-edit-close',function(){
    $('#event-edit').modal('hide');
});

window.livewire.on('md-del',function(){
    $('#event-del').modal('show');
});
window.livewire.on('md-del-close',function(){
    $('#event-del').modal('hide');
});

</script>
</div>