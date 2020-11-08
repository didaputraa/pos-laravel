<?php
use App\Helper\common;
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengerjaan barang</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Konsumen</th>
                        <th>Tgl pesan</th>
                        <th>Progress</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
            @if(empty($table_working))
                <tr>
                    <td colspan="4" class="text-center">Tidak ada barang pengerjaan</td>
                </tr>
            @else
                @foreach($table_working as $r)
                    <tr>
                        <td>{{ $r->getKonsumen->Nama }}</td>
                        <td>{{ $r->TglPesan }}</td>
                        <td>{{ common::getPercen_working($r->IDOrder) }} %</td>
                        <td>
                            <button class="btn text-success" wire:click="initWorking('{{ $r->IDOrder }}')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-danger">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="modal-init-working" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:1000px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konfirmasi</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
                </div>
                <div class="card-body">
            @if($table_item_s == 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Terproses</th>
                            <th>Kurang</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                @if(empty($table_item))
                    <tr>
                        <td colspan="4" class="text-center">
                            <button class="btn btn-lg text-primary">
                                <i class="fa fa-print"></i>
                            </button>
                        </td>
                    </tr>
                @else
                    @foreach($table_item as $row) 
                        <tr>
                            <td>{{ $row->getHarga->getStok->getBarang->Nama }}</td>
                            <td>{{ $row->Jumlah }}</td>
                            <td>{{ $row->Terproses }}</td>
                            <td>{{ common::minWorking($row->Jumlah, $row->Terproses) }}</td>
                            <td>
                            @if(common::minWorking($row->Jumlah, $row->Terproses) == 'Selesai')
                                -
                            @else
                                <button class="btn btn-sm text-success" wire:click="getMaxWorking('{{ $row->IDOItem }}')">
                                    <i class="fa fa-pen"></i>
                                </button>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                    </tbody>
                </table>
            @endif
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-init-working-jml" data-backdrop="static" wire:ignore.self>
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
                        <label>Jumlah</lalbel>
                        <input type="number" min="1" max="{{ $max_working }}" wire:model="inputJml" class="w-100" />
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="proccessWorking">Proses</button>
                </div>
            </div>
        </div>
    </div>

<script>
window.livewire.on('show-working',function(){
    $('#modal-init-working').modal('show');
});
window.livewire.on('show-working-jml',function(){
    $('#modal-init-working-jml').modal('show');
});
window.livewire.on('close-working-jml',function(){
    $('#modal-init-working-jml').modal('hide');
});
</script>
</div>
