<?php
use App\Helper\common;
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengiriman barang</h3>
        </div>
        <div class="card-body">
            <table class="table" id="tbl">
                <thead>
                    <tr>
                        <th>Konsumen </th>
                        <th>Tgl Pesan</th>
                        <th>Tgl Kirim</th>
                        <th>Status</th>
                        <th>Total order</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                @if(empty($table_siapKirim))
				<tbody>
                    <tr>
                        <td colspan="4"><p class="text-center mt-2 mb-2">Belum ada barang</p></td>
                    </tr>
                </tbody>
				@endif
            </table>
        </div>
    </div>

    <div class="modal" id="modal-init" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:400px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hasil pengerjaan barang</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <div clas="form-group">
                        <label>Konfirmasi pengiriman barang</lalbel>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="proccessSend">Proses</button>
                </div>
            </div>
        </div>
    </div>

    <script>
		function initTable()
		{
			$('#tbl').DataTable({
				data: {!! $table_siapKirim !!},
				columns:[
					{
						data:'Nama'
					},
					{ 
						data : 'pesan',
						render:function(data){
							return data;
						}
					},
					{ 
						data  : 'kirim',
						render: function(data)
						{
							return data == null ? '': data;
						}
					},
					{ data : 'kondisi'},
					{ 
						data  : 'total',
						render: function(data){
							return 'Rp '+ Number(data).toLocaleString();
						}
					},
					{ 
						data  : 'kondisi',
						render: function(data,type,row){
							if(data == 'proses')
							{
								return `<button class="btn text-success" onClick="initConfirm('${row.IDOrder}')">
									<i class="fa fa-pen"></i>
								</button>`;
							}
							else{
								return '';
							}
						}
					},
				]
			});
		}
		
		initTable();
		
        function initConfirm(idItem = '')
        {
            if(idItem != '')
            {
                @this.call('initConfirm', idItem);

                $('#modal-init').modal('show');
            }
        }
		
        window.livewire.on('close-confirm',function(){
            $('#modal-init').modal('hide');
        });
		
		$('#modal-init').on('hidden.bs.modal',function(){
			Turbolinks.visit("{{ url()->current() }}",{action:'replace'});
			//initTable();
		});
    </script>
</div>