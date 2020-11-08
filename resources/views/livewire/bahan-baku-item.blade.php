<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <button wire:click="addKelipatan">+</button>
        </div>
        <form name="frm">
            <input type="hidden" value="{{ $idResep }}" id="id-resep" />
            @for($i=0; $i < $kelipatan; $i++)
            <div class="card-body">
                <div class="form-group">
                    <label>Item</label>
                    <input type="text" class="form-control item-label" />
                </div>
                <div class="form-group">
                    <label>Biaya</label>
                    <input type="number" class="form-control item-biaya" min="0" />
                </div>
            </div>
            @endfor

            <button type="button" onClick="send_s()">exam</button>
        </form>

    </div>
<script>
function send_s(){
    var elm = document.forms.frm.elements;
    var token="{{ csrf_token() }}";
    var label='', dt = '';


    for(var i=0; i < elm.length; i++)
    {
        if(elm[i].className == 'form-control item-label')
        {
            if(elm[i].value != '')
            {
                label += '{"label" :' + '"'+elm[i].value+'"';
            }
            else{
                label += '{"label" :null';
            }
        }

        if(elm[i].className == 'form-control item-biaya')
        {
            if(elm[i].value != '')
            {
                label += ',"biaya": '+ elm[i].value + "},";
            }
            else{
                label += ',"biaya":null},';
            }
        }
    }

    dt = label.substr(0,label.length-1);
    dt = '['+ dt +']';

    $.ajax({
        url:"{{ route('baku.addItem') }}",
        method:'POST',
        data:{
            id:$('#id-resep').val(),
            inputan :dt
        },
        headers:{
            'X-CSRF-TOKEN':token
        }
    }).done(e=>{
        
    });
}

</script>
</div>
