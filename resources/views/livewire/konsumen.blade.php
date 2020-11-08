<div class="col-lg-12">
	<div class="card info-box-border border-primary">
		<div class="card-header bg-white">
			<h5 class="card-title">
				<svg width="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" fill="#007BFF">
					<path d="M13 0C9.699219 0 7 2.101563 7 6C7 8.609375 8.214844 11.3125 10 12.8125L10 14.1875C10 14.789063 9.59375 15.304688 9.09375 15.40625C5.195313 16.605469 2 19.1875 2 20.6875L2 22.5C2 24.398438 6.898438 26 13 26C19.101563 26 24 24.398438 24 22.5L24 20.6875C24 19.289063 20.90625 16.605469 16.90625 15.40625C16.40625 15.304688 16 14.6875 16 14.1875L16 12.8125C17.785156 11.3125 19 8.609375 19 6C19 2.101563 16.300781 0 13 0Z" fill="#007BFF" />
				</svg>
				<b>Data Konsumen</b>
			</h5>
		</div>
	</div>
	<div class="card">
		<div class="card-header" style="border:none">
			<button class="btn btn-outline-success" data-toggle="modal" data-target="#m-add">
				<i class="fa fa-plus">&nbsp;Tambah</i>
			</button>
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
					<td style="text-align:center">
						<button class="btn btn-sm text-secondary" onClick="showById('{{ $row->IDKonsumen }}')">
							<i class="fa fa-edit"></i>
						</button>
						<button class="btn btn-sm text-danger" onClick="preferDel('{{ $row->IDKonsumen }}')" data-toggle="modal" data-target="#m-del">
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
					<h4 class="card-title">E</h4>
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
					<button class="btn btn-outline-primary float-right" onClick="sendDel()">Konfirmasi</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		var xtoken = '{{ $token }}';
		$('#table-data').DataTable();
		
		function visitKonsumen()
		{
			Turbolinks.visit('konsumen',{action:'replace'});
		}

		function sendStore(){
			$.ajax({
				url:"{{ route('k.simpan') }}",
				method:'POST',
				data:{
					nm		: $('#a_nm').val(),
					almt	: $('#a_almt').val(),
					jk		: document.frma.ajk.value,
					telp	: $('#a_telp').val(),
					email	: $('#a_email').val()
				},
				headers:{
					'X-CSRF-TOKEN': xtoken
				}
			}).done(e=>{
				$('#m-add').modal('hide');
				visitKonsumen();
			});
		}


		function showById(id=''){
			$.ajax({
				url: '{{ url('/konsumen/show') }}/'+id
			}).done(e=>{
				let jk = e.Gender == 'L' ? '#e_jk1' : '#e_jk2';
				
				$('#e_id').val(e.IDKonsumen);
				$('#e_nm').val(e.Nama);
				$(jk).attr('checked','on');
				$('#e_email').val(e.Email);
				$('#e_telp').val(e.NoTelp);
				$('#e_almt').val(e.Alamat);
				
				$('#m-edit').modal('show');
			});
		}

		function sendUpdate()
		{
			$.ajax({
				url:'{{ route('k.update') }}',
				method:'PUT',
				data:{
					id		: $('#e_id').val(),
					nm		: $('#e_nm').val(),
					almt	: $('#e_almt').val(),
					jk		: document.frme.ejk.value,
					telp	: $('#e_telp').val(),
					email	: $('#e_email').val()
				},
				headers:{
					'X-CSRF-TOKEN': xtoken
				}
			}).done(e =>{
				$('#m-edit').modal('hide');
				visitKonsumen();
			}).fail(e=>{
				console.log(e);
			});
		}

		function preferDel(id){
			$.ajax({
				url:'{{ url('konsumen/show') }}/'+id
			}).done(e=>{
				$('#d_id').val(e.IDKonsumen);
				$('#m-del').modal('show');
			});
		}

		function sendDel(){
			$.ajax({
				url:"{{ route('k.delete') }}",
				method:'DELETE',
				data:{
					id: $('#d_id').val(),
				},
				headers:{
					'X-CSRF-TOKEN': xtoken
				}
			}).done(e=>{
				$('#m-del').modal('hide');
				$('#m_id').removeAttr('value');
				visitKonsumen();
			});
		}

	</script>
	
</div>