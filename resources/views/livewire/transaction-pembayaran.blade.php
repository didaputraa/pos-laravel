<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pembayaran</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Konsumen</th>
                        <th>Tgl pesan</th>
                        <th>Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
            @if(!empty($table_pembayaran))
                @foreach($table_pembayaran as $i)
                <tr>
                    <td>{{ $i->konsumen }}</td>
                    <td>{{ $i->TglPesan }}</td>
                    <td>Rp {{ number_format($i->total,0,',','.') }}</td>
                    <td>
                        <button class="btn btn-sm text-success" wire:click="showKonfirmasi('{{ $i->IDOrder }}','{{ $i->total }}')">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button class="btn btn-sm text-danger" wire:click="$emit('show-konfirmasi-del','{{ $i->IDOrder }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4"><p class="text-center mt-2">Belum terdapat orderan</p></td>
                </tr>
            @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="modal-init-pembayaran" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:500px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konfirmasi pembayaran</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Jumlah uang yg di bayar</label>
                        <input type="number" class="form-control" id="bayar" onChange="kembalian()" wire:model="inputUser">
                    </div>
                    <div class="form-group">
                        <label>Debet</label>
                        <input type="number" class="form-control" readonly wire:model="debet">
                    </div>
                    <div class="form-group">
                        <label>Kembalian</label>
                        <input type="number" value="0" id="kembalian" class="form-control" readonly >
                    </div>
                    <p class="text-sm">
                    jika uang yg di bayar kurang dari debet, maka akan otomatis masuk dalam piutang
                    </p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="bayar">Proses</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-init-penghapusan" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:500px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konfirmasi</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Konfirmasi pembatalan order</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="batalBeli">Proses</button>
                </div>
            </div>
        </div>
    </div>

<script>
window.livewire.on('show-konfirmasi',function()
{
    //this set('inputUser', 0);
    $('#kembalian').val(0);

    //this set('orderID', id);
    //this set('debet', total);

    $('#modal-init-pembayaran').modal('show');
});

window.livewire.on('close-pembayaran',function()
{
    $('#modal-init-pembayaran').modal('hide');
});

window.livewire.on('show-konfirmasi-del',function(id)
{
    @this.set('orderID', id);
    $('#modal-init-penghapusan').modal('show');
});

window.livewire.on('close-pembatalan',function()
{
    $('#modal-init-penghapusan').modal('hide');
});

function kembalian()
{
    let debet   = Number(@this.get('debet'));
    let jml     = Number($('#bayar').val());
    let tot     = 0;

    if(jml > debet)
    {
        tot = jml - debet;
    }

    $('#kembalian').val(tot);
}
</script>
</div>
