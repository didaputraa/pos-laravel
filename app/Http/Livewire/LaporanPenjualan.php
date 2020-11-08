<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Laporanpenjualan extends Component
{
	public $minggu = 0;
	
	public function mount()
	{
		$this->minggu = floor(date('d', Carbon::now()->timestamp) / 7);
	}
	
    public function render()
    {
        return view('livewire.laporan-penjualan');
    }
}
