<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\EventList as BrgEvent;
use App\Product;


class Events extends Component
{
    public $nmAdd = '', $idEdit = '', $idDel = '', $nmEdit = '';
    public $tglStart_add, $tglStart_edit;
    public $tglEnd_add = '', $tglEnd_edit = '';
    public $statusEvt;


    public function store()
    {
        if($this->nmAdd != '')
        {
            $for= $this->tglStart_add == ''? NULL : $this->tglStart_add;
            $to = $this->tglEnd_add == ''? NULL :  $this->tglEnd_add;

            $db = new BrgEvent;
            $db->IDBrgEvt   = Product::getID_event();
            $db->Nama       = $this->nmAdd;
            $db->TglMulai   = $for;
            $db->TglSelesai = $to;
            $db->save();

            $this->nmAdd        = '';
            $this->tglStart_add = '';
            $this->tglEnd_add   = '';
            
            $this->emit('md-add-close');
            $this->render();
        }
    }

    public function update()
    {
        if($this->idEdit)
        {
            $status = $this->statusEvt != '' ? 1 : 0;

            $db = BrgEvent::find($this->idEdit);
            $db->Nama       = $this->nmEdit;
            $db->TglMulai   = ($this->tglStart_edit=='' ? NULL : $this->tglStart_edit);
            $db->TglSelesai = ($this->tglEnd_edit =='' ? NULL  : $this->tglEnd_edit);
            $db->Status     = $status;
            $db->save();

            $this->emit('md-edit-close');

            $this->tglEnd_edit  = '';
            $this->tglStart_edit = '';
            $this->nmEdit       = '';
            $this->idEdit       = '';
            $this->statusEvt    = '';

            $this->render();
        }
    }

    public function remove()
    {
        if($this->idDel != '')
        {
            BrgEvent::destroy($this->idDel);
            $this->idDel = '';
            $this->emit('md-del-close');

            $this->render();
        }
    }



    public function initEdit($id)
    {
        $res = BrgEvent::where('IDBrgEvt',$id)->first();

        if($id != '' && !empty($res))
        {
            $status = $res->Status == 1? 1 : 0;

            $this->idEdit       = $id;
            $this->nmEdit       = $res->Nama;
            $this->tglStart_edit= $res->TglMulai;
            $this->tglEnd_edit  = $res->TglSelesai;
            $this->statusEvt    = $status;

            $this->emit('md-edit');
        }
    }

    public function initDel($id)
    {
        if($id != '')
        {
            $this->idDel = $id;

            $this->emit('md-del');
        }
    }

    public function render()
    {
        return view('livewire.events',[
            'table' => BrgEvent::all()
        ]);
    }
}