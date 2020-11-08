<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pembayaran</h3>
        </div>
        <div class="card-body" wire:ignore>
            <table class="table" id="tbl">
                <thead>
                    <tr>
                        <th>Konsumen</th>
                        <th>Tgl Order</th>
                        <th>hutang</th>
                        <th>Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal" id="modal-pembayaran" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:980px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pembayaran</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Input bayar</label>
                        <input type="number" class="form-control" min="0" id="inputBayar" wire:model="inputBayar" wire:change="perhitungan" />
                    </div>
                    <div class="form-group">
                        <label>Kurang</label>
                        <input type="text" class="form-control" wire:model="kurang" readonly />
                    </div>
                    <div class="form-group">
                        <label>Kembalian</label>
                        <input type="text" class="form-control" wire:model="kembalian" readonly />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" {{ $prosesStatus==0? 'disabled' : '' }} wire:click="pembayaran">Proses</button>
                </div>
            </div>
        </div>
    </div>

<script>
window.livewire.on('show-pembayaran',function(){
    $('#modal-pembayaran').modal('show');
});

window.livewire.on('close-pembayaran',function(){
    $('#modal-pembayaran').modal('hide');
    $('#kurang').val('');
    $('#kembalian').val('');
    @this.set('inputBayar',0);
});

function initTable()
{
    $('#tbl').DataTable().destroy();
    $('#tbl').DataTable({
        ajax    : "{{ route('produk.piutang') }}",
        columns : [
            {'data' : 'konsumen'},
            {'data' : 'TglPesan'},
            {
                'data'  : 'hutang',
                'render': function(data){
                    return Number(data).toLocaleString();
                }
            },
            {
                'data'  : 'total',
                'render': function(data){
                    return Number(data).toLocaleString();
                }
            },
            {
                'data'  : 'IDOrder',
                'render': function(data){
                    return `
                    <button class="btn btn-primary" onClick="initModalPembayaran('${data}')">
                        <i class="fa fa-pen"></i>
                    </button>`;
                }
            }
        ]
    });
}
initTable();

function initModalPembayaran(idItem)
{
    if(idItem != '')
    {
        @this.call('initModalPembayaran', idItem);
    }
}

$('#modal-pembayaran').on('hidden.bs.modal',function(){
   initTable();
    $('#kurang').val('');
    $('#kembalian').val('');
    @this.set('inputBayar',0);
});
</script>
</div>
