<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Harga;


class Barangharga extends Component
{
    public function render()
    {
        return view('livewire.barangharga',[
            'table' => Harga::all()
        ]);
    }
}
