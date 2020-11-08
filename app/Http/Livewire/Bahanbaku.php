<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Resep;

class Bahanbaku extends Component
{
    public $table    = [];
    public $ll       = '';

    
    public function submitAdd()
    {
        
    }

    public function getPage()
    {
        $this->ll = 100;
    }

    public function getSearch()
    {

    }

    public function render()
    {

        $this->table = Resep::all();

        return view('livewire.bahan-baku');
    }
}