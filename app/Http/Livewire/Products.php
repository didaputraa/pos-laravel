<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Harga;
use App\Brand;
use App\Fiturs;


class Products extends Component
{
    
    public function render()
    {
		DB::enableQueryLog();
		
        $db = Harga::with('getStok')->get();//all();
		dd(DB::getQueryLog());
		
        return view('livewire.products',[
            'table'         => $db,
            'table_brand'   => Brand::all(),
            'fiturs'        => Fiturs::first()
        ]);
        
    }
}
