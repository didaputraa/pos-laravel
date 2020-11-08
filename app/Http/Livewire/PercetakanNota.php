<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\{Orders,Fiturs};

class Percetakannota extends Component
{
	public $print = 0;
	public $order;
	public $tot = 0;
	public $perusahaan = ['nama'=>'', 'alamat'=>'', 'telp'=>'', 'email'=>''];
	
	
	public function kembali()
	{
		$this->print = 0;
	}
	
	public function Order($item)
	{
		if($item != '')
		{
			$this->order = Orders::where('IDOrder', $item)->first();
			$f 			 = Fiturs::first();
			
			$this->perusahaan['nama']	= $f->Nama;
			$this->perusahaan['email']	= $f->Email;
			$this->perusahaan['telp']	= $f->NoTelp;
			$this->perusahaan['alamat'] = $f->Alamat;
			
			$this->print = 1;
		}
	}
	
    public function render()
    {
        return view('livewire.percetakan-nota');
    }
}
