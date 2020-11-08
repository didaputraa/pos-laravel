<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Bahanbakuitem extends Component
{
    public $idResep;
    public $kelipatan = 1;


    public function addKelipatan()
    {
        $this->kelipatan += 1;
    }

    public function mount($id)
    {
        $this->idResep = $id;
    }

    public function render()
    {
        return view('livewire.bahan-baku-item');
    }
}
