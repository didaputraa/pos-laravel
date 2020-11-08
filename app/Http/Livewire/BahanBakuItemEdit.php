<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Resep;


class Bahanbakuitemedit extends Component
{
    public $idItem;
    public $table;
    public $kelipatan = 0;

    
    public function addKolom()
    {
        array_push($this->table,["label" => '', 'biaya' => '']);
    }

    public function mount($id)
    {
        $this->idItem = $id;

        $res = Resep::where('IDBPR',$id)->first();

        if(!empty($res))
        {
            $json = json_decode($res->RincianItem,true);

            if(is_array($json) && $json != '-')
            {
                $this->table = $json;
            }else{
                $this->table = [0=>["label" => '', 'biaya' => '']];
            }
        }
    }

    public function render()
    {
        return view('livewire.bahan-baku-item-edit');
    }
}
