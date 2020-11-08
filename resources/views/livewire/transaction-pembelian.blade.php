<div class="col-lg-12">

@switch($pageActiveNow)

    @case('view')
        <button class="btn btn-success" wire:click="showInitPembelian">
            <i class="fa fa-plus"></i> Pembelian
        </button>
        <div class="card" wire:ignore>
            <div class="card-header">
                <h3 class="card-title">Pembelian</h3>
            </div>
            <div class="card-body">
            
                    <table class="table" id="tbl">
                        <thead>
                            <tr>
                                <th >Total biaya</th>
                                <th >Tgl pembelian</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                    
            </div>
        </div>

    <div class="modal" id="modal-delItem" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:500px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konfirmasi</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    Konfirmasi penghapusan pembelian
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="deleteItem">Proses</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-eyes" data-backdrop="static" wire:ignore.self>
        <div class="container-fluid mt-5" style="max-width:900px">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">info</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="text-center mb-2">Rincian pembelian</h5>
                    @if(!empty($tblEye))
                        <table class="table">
                            <tr>
                                <th>Item</th>
                                <th>Biaya</th>
                            </tr>
                            @foreach(json_decode($tblEye->RincianItem) as $row)
                            <tr>
                                <td>{{ $row->label }}</td>
                                <td>{{ $row->biaya }}</td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="form-group">
                            <label>Biaya pembelian </label>
                            <input type="text" class="form-control" value="{{ number_format($tblEye->Biaya, 0,'.',',') }}" readonly />
                        </div>
                        <div class="form-group">
                            <label>Biaya Pembelian lainnya</label>
                            <input type="text" class="form-control" value="{{ $tblEye->BiayaLain }}" readonly />
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function initTable()
    {
        $('#tbl').DataTable().destroy();
        $('#tbl').DataTable({
            ajax    : "{{ url('/pembelian/api/show') }}",
            columns : [
                { 
                    'data' : 'total',
                    render : function(data)
                    {
                        return (data).toLocaleString();
                    }
                },
                { 'data' : 'Tgl' },
                { 
                    'data' : 'IDP',
                    render : function(data)
                    {
                        return (`
                            <button class="btn text-primary" onClick="initView('${data}')"><i class="fa fa-eye"></i></button>
                            <button class="btn text-danger" onClick="initDel('${data}')"><i class="fa fa-trash-alt"></i></button>
                        `);
                    }
                }
            ]
        });
    }

    function initDel(idItem)
    {
        if(idItem != '')
        {
            @this.set('idDel', idItem);
            $('#modal-delItem').modal('show');
        }
    }

    initTable();

    $('#modal-delItem').on('hidden.bs.modal', function(){
        initTable();
    });

    $('#modal-eyes').on('hidden.bs.modal', function(){
        @this.call('emptyEye');
    });
    </script>
    @break

    @case('pembelian')
    <a class="btn btn-outline-primary" wire:click="backViewFront">Batal</a>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pembelian item</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Tanggal pembelian</label>
                <input type="date" value='{{ date("Y-m-d",strtotime("now")) }}' wire:model="tgl" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Biaya lain</label>
                <input type="number" class="form-control" wire:model="biayaLain"/>
            </div>
            <div class="form-group" wire:ignore>
                <label>Item</label>
                <select class="form-control select2"  multiple="multiple" id="itemselect"></select>
            </div>
        </div>
        <div class="card-footer" wire:ignore.self>
            <button class="btn btn-outline-primary float-right" onClick="prosesPembelian()">Proses</button>
        </div>
    </div>

    <div class="modal" id="modal-additem" wire:ignore.self>
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
                        <input type="number" class="form-control" id="bayar" onChange="" wire:model="inputUser">
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary float-right" wire:click="">Proses</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        {!! $tblItem !!}.forEach(row=>{
            $('#itemselect').append(`<option value="${row.IDBPR}">${row.Label}</option>`);
        });

        var pilihItem = [];

        $('#itemselect').select2({
            theme: 'bootstrap4'
        });

        $('#itemselect').on('change',function(e)
        {
            let target  = e.target.selectedOptions;
            let pjg     = target.length;
            let ary     = '';

            for(let i=0; i< pjg; i++)
            {
                ary += target[i].value + ',';
            }

            pilihItem.pop();
            pilihItem.push(ary);

            @this.set('select2', pilihItem.toString());
        });
    </script>
    @break
@endswitch

<script>
window.livewire.on('a',function(){
    
});
window.livewire.on('b',function(){
    
});
window.livewire.on('close-del',function(){;
    $('#modal-delItem').modal('hide');
});

function initView(idItem)
{
    if(idItem != '')
    {
        @this.call('viewItem_pembelian', idItem);
        $('#modal-eyes').modal('show');
    }
}

function prosesPembelian()
{
    @this.call('send');
}

</script>
</div>
