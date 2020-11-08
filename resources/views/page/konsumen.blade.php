<div class="col-lg-12">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title d-inline">Konsumen </h5>&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-success d-inline" data-toggle="modal" data-target="#m-add"><i class="fa fa-plus"></i></button>
		</div>
		<div class="card-body">
			<table class="table" id="table-data">
			<thead>
				<tr>
					<th>Nama</th>
					<th>No telp</th>
					<th>Gender</th>
					<th>Alamat</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
			@foreach($table as $row)
				<tr>
					<td>{{ $row->Nama }}</td>
					<td>{{ $row->NoTelp }}</td>
					<td>{{ $row->Gender }}</td>
					<td>{{ $row->Alamat }}</td>
					<td>
						<button class="btn btn-sm btn-warning" onClick="showById('{{ $row->IDKonsumen }}')">
							<i class="fa fa-edit"></i>
						</button>
						<button class="btn btn-sm btn-danger" onClick="preferDel('{{ $row->IDKonsumen }}')">
							<i class="fa fa-trash-alt"></i>
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
			</table>
		</div>
	</div>
	
	<div class="modal mt-2" id="m-add">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
				<div class="card-header p-4">
					<h1 class="card-title">Edit Konsumen</h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
				</div>
				
				<div class="card-body">
					<form name="frma">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="nm" id="a_nm" class="form-control" />
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" id="a_email" class="form-control" />
						</div>
						<div class="form-group">
							<label>No telp</label>
							<input type="text" name="telp" id="a_telp" class="form-control" />
						</div>
						<div class="form-group">
							<label>Gender</label>
							 <div class="icheck-primary">
								<input type="radio" id="a_jk1" name="ajk" value="L">
								<label for="a_jk1">Laki-laki</label>
							</div>
							<div class="icheck-primary">
								<input type="radio" id="a_jk2" name="ajk" value="P">
								<label for="a_jk2">Perempuan</label>
							</div>
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea name="almt" id="a_almt" class="form-control"></textarea>
						</div>
					</form>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendStore()">Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal mt-2" id="m-edit">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
				<div class="card-header">
				
				</div>
				<div class="card-body">
					<form name="frme">
						<div class="form-group">
							<label>Nama</label>
							<input type="hidden" name="nm" id="e_id" />
							<input type="text" name="nm" id="e_nm" class="form-control" />
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" id="e_email" class="form-control" />
						</div>
						<div class="form-group">
							<label>No telp</label>
							<input type="text" name="telp" id="e_telp" class="form-control" />
						</div>
						<div class="form-group">
							<label>Gender</label>
							 <div class="icheck-primary">
								<input type="radio" id="e_jk1" name="ejk" value="L">
								<label for="e_jk1">Laki-laki</label>
							</div>
							<div class="icheck-primary">
								<input type="radio" id="e_jk2" name="ejk" value="P">
								<label for="e_jk2">Perempuan</label>
							</div>
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea name="almt" id="e_almt" class="form-control"></textarea>
						</div>
					</form>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendUpdate()">Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal mt-2" id="m-del">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
				<div class="card-header p-4">
					<h1 class="card-title">Hapus Data Konsumen</h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
				</div>
				<div class="card-body">
					<p>Yakin ingin menghapus konsumen ini
					<input type="hidden" id="d_id"/>
				</div>
				<div class="card-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendDel()">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>