<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Orders;
use App\Fiturs;


class Percetakanresi extends Component
{
	public $tbl = [], $printing = 0, $noResi = '', $fitur = '';
	
	
	public function preparePrinting($idItem)
	{
		$this->noResi	= Orders::find($idItem);
		$this->fitur	= Fiturs::first();
		$this->printing = 1;
	}
	
	public function backViewer()
	{
		$this->noResi 	= '';
		$this->printing = 0;
	}
	
	public function mount()
	{
		$tbl	= [];
		$result = DB::table('orders')->select(
			'orders.IDOrder',
			'orders.IDEkspedisi as ekspedisi',
			'konsumen.Nama',
			'orders.TglPesan as pesan',
			'orders.TglKirim as kirim',
			DB::raw('SUM(order_item.Jumlah * order_item.Harga) + orders.Ongkir as total')
		)
		->join('konsumen','orders.IDKonsumen','=','konsumen.IDKonsumen')
		->join('order_item','orders.IDOrder','=','order_item.IDOrder')
		->where('orders.IDOS', 3)
		->orWhere('orders.IDOS', 4)
		->groupBy('orders.IDOrder','orders.IDEkspedisi','konsumen.Nama','orders.TglPesan','orders.TglKirim','orders.Ongkir');
		
		if($result->count() > 0)
		{
			$tbl = $result->orderByDesc('pesan')->get();
		}
		
		$this->tbl = json_encode($tbl);
	}
	
    public function render()
    {
        return view('livewire.percetakan-resi');
    }
}
