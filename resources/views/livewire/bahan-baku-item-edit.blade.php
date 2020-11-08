<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit item bahan baku</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-success float-right" wire:click="addKolom()"><i class="fa fa-plus"></i>Tambah item</button>
        </div>
        <div class="card-body">
        <label class="text-sm">NB: jika ingin hapus / tidak digunakan kosongkan data pada kolom inputan</label><br>
        <form name="frm">
        @foreach($table as $r)
            <div class="form-group">
                <label>Nama item</label>
                <input type="text" class="form-control item_label" value="{{ $r['label'] }}" />
            </div>
            <div class="form-group">
                <label>Biaya</label>
                <input type="number" class="form-control item_biaya" min="0" value="{{ $r['biaya'] }}" />
            </div>
        @endforeach
        </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-secondary" onClick="Turbolinks.visit('{{ url('bahan-baku') }}',{action:'replace'})">Batal</button>
            <button class="btn btn-outline-primary float-right" type="button" onClick="initSend()">Update</button>
        </div>
    </div>

<script>
    function initSend()
    {
        let komponen    = document.forms.frm.elements;
        var label       = '', 
            json_init   = '';
        var xtoken      = '{{ csrf_token() }}';

        for(let i=0; i<komponen.length; i++)
        {
            if(komponen[i].className == 'form-control item_label')
            {
                if(komponen[i].value != '')
                {
                    label += '{"label" :' + '"'+ komponen[i].value +'"';
                }
                else{
                    label += '{"label" :null';
                }
            }
            if(komponen[i].className == 'form-control item_biaya')
            {
                if(komponen[i].value != '')
                {
                    label += ',"biaya": '+ komponen[i].value + "},";
                }
                else{
                    label += ',"biaya":null},';
                }
            }
        }

        json_init = '[' + label.substr(0,label.length-1) + ']';
        
        $.ajax({
            url:"{{ route('baku.update-item') }}",
            method:'PUT',
            data:{
                id:"{{ $idItem }}",
                inputan:json_init
            },
            headers:{
                'X-CSRF-TOKEN': xtoken
            }
        }).done(e=>{
            Turbolinks.visit(baseURL+'/bahan-baku',{action:'replace'});
        });
    }
</script>
</div>
