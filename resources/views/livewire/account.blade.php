<div class="col-lg-12">
    <button class="btn btn-success mb-3" data-target="#tambah" data-toggle="modal">
        <i class="fa fa-plus"></i> Tambah pengguna
    </button>
    <div class="card">
        <div class="card-header">
            <p class="card-title">Account</p>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Akses</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tbl as $r)
                    <tr>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->level }}</td>
                        <td>
                            <button class="btn text-secondary" wire:click="initEdit('{{ $r->id }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-danger" wire:click="initDel('{{ $r->id }}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="tambah" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid" style="max-width:900px">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Tambah pengguna</p>
                    <button class="close text-danger" data-dismiss="modal">x</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model="addAkun.nama" />
                        @error('addAkun.nama')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="addAkun.email" />
                        @error('addAkun.email')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" wire:model="addAkun.password" />
                        @error('addAkun.password')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Akses</label>
                        <select class="form-control" wire:model="addAkun.level">
                            @foreach(['admin', 'operator', 'stok'] as $r)
                                <option value="{{ $r }}" >{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('addAkun.level')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary float-right" wire:click="simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="edit" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid" style="max-width:900px">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Update data</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model="editAkun.nama" />
                        @error('editAkun.nama')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="editAkun.email" />
                        @error('editAkun.email')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password baru</label>
                        <input type="text" class="form-control" wire:model="editAkun.password" />
                        @error('editAkun.password')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Akses</label>
                        <select class="form-control" wire:model="editAkun.level">
                            @foreach(['admin', 'operator', 'stok'] as $r)
                                <option value="{{ $r }}" >{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('editAkun.level')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary float-right" wire:click="update">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="del">
        <div class="container-fluid" style="max-width:500px">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Konfirmasi</p>
                </div>
                <div class="card-body">
                    <p>Konfirmasi penghapusan data</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary float-right" wire:click="del">Simpan</button>
                </div>
            </div>
        </div>
    </div>

<script>
window.livewire.on('close-add', function(){
    $('#tambah').modal('hide');
});

window.livewire.on('show-edit', function(){
    $('#edit').modal('show');
});

window.livewire.on('close-edit', function(){
    $('#edit').modal('hide');
    @this.call('resetValidations');
});

window.livewire.on('show-konfirmasi', function(){
    $('#del').modal('show');
});

window.livewire.on('close-konfirmasi', function(){
    $('#del').modal('hide');
});
</script>

</div>