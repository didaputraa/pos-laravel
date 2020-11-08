<div class="col-lg-12">
@switch($act)
@case('view')
    <div class="card">
        <div class="card-header">
            <p class="card-title">Data Produk Update</p>
            <a wire:click="clik">dwd</a>
        </div>
        <div class="card-body" wire:ignore>
            <table class="table" id="tbl">
                <thead>
                <tr>
                    <th>Nama barang</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<script>
function initTable()
{
    $('#tbl').DataTable({
        data:{!! $tbl !!},
        columns:[
            {
                'data' : 'get_harga.get_stok.get_barang.Nama',
                render : function(data, type, row){
                    return `${row.get_harga.get_stok.get_barang.Nama} ${row.get_harga.get_stok.get_barang.get_jenis.Nama} ${row.get_harga.get_stok.get_barang.get_jenis.get_kategori.Nama}`;
                }
            },
            {'data' : 'Ket'},
            {
                'data' : 'Jenis',
                render : function(data)
                {
                    return data == 1? `Tambah stok` : '';
                }
            },
            {
                'data' : 'IDR',
                render : function(data)
                {
                    return `
                        <input type="hidden" id="${data}-tujuan" wire:model="tujuan" />
                        <button class="btn text-secondary" onClick="initEdit('${data}')"><i class="fa fa-pen"></i></button>
                    `;
                }
            }
        ]
    });
}
initTable();

function initEdit(idItem)
{
    if(idItem != '')
    {
        $.ajax({
            url: "{{ url('product/api/request-extra-getjenis') }}/"+ idItem
        }).done(evt=>{

            Turbolinks.visit("{{ url()->current() }}?act="+ evt.tujuan +"&id="+ idItem, {action:'replace'});

        });
    }
}
</script>
@break

@case('edit')
<a class="btn btn-primary mb-3" href="{{ url('product/request-extra/?act=view') }}" data-turbolinks-action="replace">Batal</a>
<div class="card">
    <div class="card-header">
        <p class="card-title">Update data product</p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Nama barang</label>
                    <input type="text" class="form-control" wire:model="nm" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Nama pendek</label>
                    <input type="text" class="form-control" wire:model="nm_short" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Kode barang</label>
                    <input type="text" class="form-control" wire:model="kodeBrg" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Ubah gambar produk</label>
                    <div class="input-group">
                        <div class="custom-file" wire:ignore>
                            <input type="file"class="custom-file-input" id="exampleInputFile" wire:model="photo">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <label><input type="checkbox"/> Ubah gambar</label>
            </div>
            <div class="col-lg-6">
                <div class="form-group" wire:ignore.self>
                    <label>Brand</label>
                    <select class="form-control select2" id="brand" wire:model="itemBrand" wire:change="changeKategori">
                        @foreach($tbl_brand as $r)
                            <option value="{{ $r->IDBrand }}">{{ $r->Nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control select2" id="kategori" wire:model="itemKategori" wire:change="changeJenis">
                        <option>--pilih--</option>
                        @foreach($tbl_kategori as $r)
                            <option value="{{ $r->IDBrgKategori }}">{{ $r->Nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis</label>
                    <select class="form-control select2" id="jenis" wire:model="itemJenis">
                        <option>--pilih--</option>
                        @foreach($tbl_jenis as $r)
                            <option value="{{ $r->IDBrgJenis }}">{{ $r->Nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($fiturs->barangEvt)
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Event</label>
                    <select class="form-control select2" wire:model="itemEvent">
                        @foreach($tbl_event as $r)
                            <option value="{{ $r->IDBrgEvt}}">{{ $r->Nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            
        </div>
    </div>
    <div class="card-footer">
        <button class="float-right btn btn-primary" onClick="initKonfirmasi()">Konfirmasi</button>
    </div>
</div>

<div class="modal" id="modal-konfirmasi" wire:ignore.self>
    <div class="container-fluid" style="max-width:500px">
        <div class="card">
            <div class="card-header">
                <p class="card-title">Konfirmasi</p>
            </div>
            <div class="card-body">
                <p>Konfirmasi untuk melakukan proses</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button class="float-right btn btn-primary" onClick="konfirmasi()">Proses</button>
            </div>
        </div>
    </div>
</div>

<script>
window.livewire.on('close-konfirmasi', function(){
    $('#modal-konfirmasi').modal('hide');
    Turbolinks.visit("{{ url('product/request-extra/?act=view') }}",{action : 'replace'});
});

function initKonfirmasi()
{
    $('#modal-konfirmasi').modal('show');
}

function konfirmasi()
{
    @this.call('simpan');
}

$('#modal-konfirmasi').on('hidden.bs.modal', function(){

});

</script>
@break

@case('stok')
<div class="card">
    <div class="card-header">
        <p class="card-title">Update stok</p>
    </div>
    <div class="card-body" wire:ignore.self>
        <div class="form-group">
            <label>Jumlah Stok</label>
            <input type="number" class="form-control" wire:model="stok.jml" />
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" data-dismiss="modal">Batal</button>
        <button class="float-right btn btn-primary" wire:click="stokRequest">Proses</button>
    </div>
</div>
<script>
window.livewire.on('redirect', function(par){
    Turbolinks.visit("{{ url()->current() }}/?act="+par, {action:'replace'})
});
</script>
@break
@endswitch
</div>