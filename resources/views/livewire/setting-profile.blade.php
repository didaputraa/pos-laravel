<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <p class="card-title">Profile</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 text-center">
                    <p>{{ $profile['level'] }}</p>
                    <i class="fa fa-4x fa-user-circle"></i>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" value="{{ $profile['nama'] }}" readonly />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $profile['email'] }}" readonly />
                    </div>
                    <div class="form-group">
                        <label>Terdaftar</label>
                        <input type="text" class="form-control" value="{{ $profile['tgl'] }}" readonly />
                    </div>
                </div>
                <div class="col-lg-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit-data">
                        <i class="fa fa-edit"></i> Update data
                    </button>
					<button class="btn btn-primary" data-toggle="modal" data-target="#edit-pass">
                        <i class="fa fa-edit"></i> Update password
                    </button>
                </div>
            </div>
        </div>
    </div>
	
	<div class="modal mt-3" id="edit-data" data-backdrop="static" wire:ignore.self>
		<div class="container-fluid" style="max-width:900px">
			<div class="card">
				<div class="card-header">
					<p class="card-title">Ubah data</p>
					<button class="close text-danger" data-dismiss="modal">x</button>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" wire:model="update.nama" />
						@error('update.nama')
							<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" wire:model="update.email" />
						@error('update.email')
							<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
					<div class="form-group">
						<label>Level</label>
						<select class="form-control" wire:model="update.level">
							@foreach(['stok', 'operator', 'admin'] as $r)
								<option value="{{ $r }}">{{ $r }}</option>
							@endforeach
						</select>
						@error('update.level')
							<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" wire:click.prevent="update_data">Proses</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal mt-3" id="edit-pass" data-backdrop="static" wire:ignore.self>
		<div class="container-fluid" style="max-width:800px">
			<div class="card">
				<div class="card-header">
					<p class="card-title">Ubah password</p>
					<button class="close text-danger" data-dismiss="modal">x</button>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Password</label>
						<input type="text" class="form-control" wire:model="update.password"/>
						@error('update.password')
							<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
					<div class="form-group">
						<label>Password konfirmasi</label>
						<input type="text" class="form-control" wire:model="update.passConfirm" wire:change="validatePassword" />
						<?php /*if(!empty($update['msg']))
							<p class="text-danger text-sm">{{ $update['msg'] }}</p>
						endif*/?>
						@error('update.passConfirm')
							<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" {{ $update['act']==1?'':'disabled' }} wire:click="update_password">Proses</button>
				</div>
			</div>
		</div>
	</div>
	<script>
	window.livewire.on('close-setting-password',function(){
		$('#edit-pass').modal('hide');
	});
	</script>
</div>
