<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Brand as Brands;

class Brand extends Component
{
    public $idDel, $idEdit;
    public $nmAdd, $shrtAdd, $nmEdit, $shrtEdit;

    public function update()
    {
        if($this->idEdit != '')
        {
            $db = Brands::find($this->idEdit);
            $db->Nama       = $this->nmEdit;
            $db->ShortName  = $this->shrtEdit;
            $db->save();

            $this->nmEdit    = '';
            $this->shrtEdit  = '';
            $this->render();
            $this->emit('md-edit-close');
        }
    }

    public function store()
    {
        if($this->nmAdd != '')
        {
            $db = new Brands;
            $db->Nama       = $this->nmAdd;
            $db->ShortName  = $this->shrtAdd;
            $db->TglCreate  = date('Y-m-d H:i:s',strtotime('now'));
            $db->save();

            $this->nmAdd    = '';
            $this->shrtAdd  = '';
            $this->render();
            $this->emit('md-add-close');
        }
    }

    public function remove()
    {
        if($this->idDel != '')
        {
            Brands::destroy($this->idDel);

            $this->idDel = '';

            $this->render();
            $this->emit('md-del-close');
        }
    }


    public function initDel($id)
    {
        $this->idDel = $id;
        $this->emit('md-del');
    }

    public function initEdit($id)
    {
        if($id != '')
        {
            $db = Brands::where('IDBrand',$id)->first();

            if(!empty($db))
            {
                $this->idEdit   = $id;
                $this->nmEdit   = $db->Nama;
                $this->shrtEdit = $db->ShortName;

                $this->emit('md-edit');
            }
        }
    }

    public function render()
    {
        return view('livewire.brand',[
            'table' => Brands::all()
        ]);
    }
}
