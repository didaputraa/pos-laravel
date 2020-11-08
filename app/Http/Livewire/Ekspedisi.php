<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Ekspedisi as ekpedisi;


class Ekspedisi extends Component
{
    public $nama_add,  $tarif_add  = 0, $id_edit,
           $nama_edit, $tarif_edit = 0, $id_del;


    public function store()
    {
        $db = new ekpedisi;

        $db->IDEkspedisi = ekpedisi::getID();
        $db->Nama        = $this->nama_add;
        $db->Tarif       = $this->tarif_add;
        $db->Save();

        $this->nama_add = '';
        $this->tarif_add= '';

        $this->render();
        $this->emit('modal-add-success');
    }

    public function update()
    {
        if($this->id_edit)
        {
            $db = ekpedisi::find($this->id_edit);
			
            $db->Nama 	= $this->nama_edit;
            $db->Tarif	= $this->tarif_edit;
            $db->Save();
    
            $this->nama_edit = '';
            $this->render();
            $this->emit('modal-edit-success');
        }
    }

    public function initDel($id)
    {
        $res = ekpedisi::where('IDEkspedisi',$id)->first();

        if(!empty($res))
        {
            $this->id_del = $res->IDEkspedisi;
            $this->emit('modal-init-del');
        }
    }

    public function delete()
    {
        if($this->id_del)
        {
            ekpedisi::destroy($this->id_del);

            $this->emit('modal-success-del');
            $this->id_del = '';
            $this->render();
        }
    }



    public function initEdit($idItem)
    {
        $result = ekpedisi::where('IDEkspedisi',$idItem)->first();

        if(!empty($result))
        {
            $this->nama_edit = $result->Nama;
            $this->tarif_edit= $result->Tarif;
            $this->id_edit   = $result->IDEkspedisi;

            $this->emit('modal-edit');
        }
    }

    public function initAdd()
    {
        $this->nama_add     = '';
        $this->tarif_edit   = '';

        $this->emit('modal-add');
    }

    public function mount()
    {
        $this->table_edit = ['IDEkspedisi'=>'','Nama'=>'','Tarif' => ''];
    }

    public function render()
    {
        return view('livewire.ekspedisi',[
            'table' => ekpedisi::all()
        ]);
    }
}
