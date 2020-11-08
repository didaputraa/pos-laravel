<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Fiturs;

class Fitur extends Component
{
    //public $tmps, $events = 0, $ekspedisi = 0, $deadline = 0;
	
	public $profile = ['ekspedisi'=>'', 'deadline'=>'', 'events'=>'', 'nama'=> '', 'email'=>'', 'alamat'=>'', 'telp' => ''];
	public $edited = ['nama' => 0, 'email' => 0, 'alamat' => 0, 'telp' =>''];
	
	
	public function c_ekspedisi()
	{
		$f = Fiturs::find(0);
		
		$f->ekspedisi = $this->profile['ekspedisi'];
		
		$f->save();
	}
	
	public function c_deadline()
	{
		$f = Fiturs::find(0);
		
		$f->Deadline = $this->profile['deadline'];
		
		$f->save();
	}
	
	public function c_event()
	{
		$f = Fiturs::find(0);
		
		$f->barangEvt = $this->profile['events'];
		$f->save();
	}
	
	public function c_nama()
	{
		$f = Fiturs::find(0);
		
		$f->Nama = $this->profile['nama'];
		$f->save();
		
		$this->mount();
		$this->edited['nama'] = false;
	}
	
	public function c_email()
	{
		$f = Fiturs::find(0);
		
		$f->Email = $this->profile['email'];
		$f->save();
		
		$this->mount();
		$this->edited['email'] = false;
	}
	
	public function c_telp()
	{
		$f = Fiturs::find(0);
		
		$f->NoTelp = $this->profile['telp'];
		$f->save();
		
		$this->mount();
		$this->edited['telp'] = false;
	}
	
	public function c_alamat()
	{
		$f = Fiturs::find(0);
		
		$f->Alamat = $this->profile['alamat'];
		$f->save();
		
		$this->mount();
		$this->edited['alamat'] = false;
	}

    public function mount()
    {
        $db 	= Fiturs::first();
		$edit	= $this->edited;
		
		$this->profile['ekspedisi']   = $db->ekspedisi;
        $this->profile['deadline']    = $db->Deadline;	
        $this->profile['events']      = $db->barangEvt;	
		
		if(empty($edit['nama']))
        {
			$this->profile['nama'] = $db->Nama;
		}
		
		if(empty($edit['email']))
        {
			$this->profile['email'] = $db->Email;
		}
		
		if(empty($edit['alamat']))
        {
			$this->profile['alamat']  = $db->Alamat;
		}
		
		if(empty($edit['telp']))
        {
			$this->profile['telp'] = $db->NoTelp;
		}
    }

    public function render()
    {
        return view('livewire.fitur');
    }
}

