<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Konsumen as Customer;

class Konsumen extends Component
{
	public $table;
	public $token;
	public $importScript;

	
	public function mount()
	{
		$this->table = Customer::getAll();
		$this->token = csrf_token();
	}
	
    public function render()
    {
		return view('livewire.konsumen');
    }
}