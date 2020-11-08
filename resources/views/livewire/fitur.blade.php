<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <p class="card-title">Pengaturan</p>
        </div>
        <div class="card-body">
			<div class='row'>
			<div class="col-lg-6">
				<div class="form-group">
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" wire:model="profile.ekspedisi" id="ekspedisi" wire:change="c_ekspedisi"/>
						<label class="custom-control-label" for="ekspedisi">Ekspedisi</label>
					</div>
				</div>
				<div class="form-group">
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" wire:model="profile.deadline" id="deadline" wire:change="c_deadline()"/>
						<label class="custom-control-label" for="deadline">Deadline</label>
					</div>
				</div>
				<div class="form-group">
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" wire:model="profile.events" id="evts" wire:change="c_event" />
						<label class="custom-control-label" for="evts">Events</label>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Nama perusahaan</label>
				@if(empty($edited['nama']))
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.nama" readonly />
						<div class="input-group-prepend">
							<button class="btn text-secondary" wire:click="$set('edited.nama',1)">
								<i class="fa fa-edit"></i>
							</button>
						</div>
					</div>
				@else
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.nama" />
						<div class="input-group-prepend">
							<button class="btn text-primary" wire:click="c_nama">
								<i class="fab fa-telegram-plane"></i>
							</button>
						</div>
					</div>
				@endif
				</div>
				<div class="form-group">
					<label>Email</label>
				@if(empty($edited['email']))
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.email" readonly />
						<div class="input-group-prepend">
							<button class="btn text-secondary" wire:click="$set('edited.email',1)">
								<i class="fa fa-edit"></i>
							</button>
						</div>
					</div>
				@else
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.email" />
						<div class="input-group-prepend">
							<button class="btn text-primary" wire:click="c_email">
								<i class="fab fa-telegram-plane"></i>
							</button>
						</div>
					</div>
				@endif
				</div>
				<div class="form-group">
					<label>No telp</label>
				@if(empty($edited['telp']))
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.telp" readonly />
						<div class="input-group-prepend">
							<button class="btn text-secondary" wire:click="$set('edited.telp', 1)">
								<i class="fa fa-edit"></i>
							</button>
						</div>
					</div>
				@else
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.telp" />
						<div class="input-group-prepend">
							<button class="btn text-primary" wire:click="c_telp">
								<i class="fab fa-telegram-plane"></i>
							</button>
						</div>
					</div>
				@endif
				</div>
				<div class="form-group">
					<label>Alamat</label>
				@if(empty($edited['alamat']))
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.alamat" readonly />
						<div class="input-group-prepend">
							<button class="btn text-secondary" wire:click="$set('edited.alamat', 1)">
								<i class="fa fa-edit"></i>
							</button>
						</div>
					</div>
				@else
					<div class="input-group">
						<input type="text" class="form-control" wire:model="profile.alamat"  />
						<div class="input-group-prepend">
							<button class="btn text-primary" wire:click="c_alamat">
								<i class="fab fa-telegram-plane"></i>
							</button>
						</div>
					</div>
				@endif
				</div>
			</div>
		</div>
        </div>
    </div>
</div>
