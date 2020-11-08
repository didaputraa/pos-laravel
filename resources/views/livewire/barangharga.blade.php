<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Harga</h4>
        </div>
        <div class="card-body">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>Nama barang</th>
                        <th>Harga jual</th>
                        <th>Harga beli</th>
                        <th>Brand</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>opsi</th>
                    </tr>
                </thead>
                <tbody>
					@foreach($table as $row)
					<?php
						$brg = $row->getStok->getBarang;
						$jns = $row->getStok->getBarang->getjenis;
					?>
					<tr>
						<td>{{ $brg->Nama }}</td>
						<td>
							{{ $row->HargaJual }}
							<input type="hidden" value="{{ $row->HargaJual }}" id="harga-jual-{{ $row->IDHarga }}" readonly />
						</td>
						<td>
							{{ $row->HargaBeli }}
							<input type="hidden" value="{{ $row->HargaBeli }}" id="harga-beli-{{ $row->IDHarga }}" readonly />
						</td>
						<td>{{ $jns->getKategori->getBrand->Nama }}</td>
						<td>{{ $jns->Nama }}</td>
						<td>{{ $jns->getKategori->Nama }}</td>
						<td class="text-center">
							<button class="btn btn-sm text-secondary" onClick="initEdit('{{ $row->IDHarga }}')">
								<i class="fa fa-edit"></i>
							</button>
						</td>
					</tr>
					@endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal mt-2" id="harga-edit">
		<div class="container-fluid" style="max-width:1000px">
			<div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ubah harga produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Harga Jual</label>
                        <input type="number" id="harga-edit-jual" class="form-control" min="0" />
                        <input type="hidden" id="harga-edit-id" />
                    </div>
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="number" id="harga-edit-beli" class="form-control" min="0" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
					<button class="btn btn-outline-primary float-right" onClick="sendEdit()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>
		$('#table-data').DataTable();
		var xtoken_ = "{{ csrf_token() }}";

		function initEdit(id)
		{
			if(id != '')
			{
				$('#harga-edit-id').val(id);
				$('#harga-edit-jual').val($('#harga-jual-'+id).val());
				$('#harga-edit-beli').val($('#harga-beli-'+id).val());
				$('#harga-edit').modal('show');
			}
		}

		function sendEdit()
		{
			$.ajax({
				url:"{{ route('produk.update-harga') }}",
				data:
				{
					id      : $('#harga-edit-id').val(),
					jual    : $('#harga-edit-jual').val(),
					beli    : $('#harga-edit-beli').val()
				},
				method:'PUT',
				headers:{
					'X-CSRF-TOKEN':xtoken_
				}
			}).done(e=>{
				Turbolinks.visit(baseURL+'/product/harga',{action:'replace'});
			});
		}

		$('#harga-edit').on('hidden.bs.modal',function(){
			$('#harga-edit-jual').val('');
			$('#harga-edit-beli').val('');
		});
    </script>
	
</div>
