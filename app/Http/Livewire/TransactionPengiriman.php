<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Orders;

class Transactionpengiriman extends Component
{
    public $itemOrder, $table_siapKirim = [];


    public function proccessSend()
    {
        if($this->itemOrder != '')
        {
            $db = Orders::find($this->itemOrder);

            $db->TglKirim = date('Y-m-d H:i:s',strtotime('now'));
            $db->IDOS     = 4;

            $db->save();
        }

        $this->emit('close-confirm');
    }

    public function initConfirm($id)
    {
        if($id != '')
        {
            $this->itemOrder = $id;
        }
    }

    public function render()
    {
		$tbl    = [];
		
		$result = DB::table('orders')->select(
			'orders.IDOrder',
			'konsumen.Nama',
			'orders.TglPesan as pesan',
			'orders.TglKirim as kirim',
			DB::raw("if(orders.IDOS = 4,'selesai','proses')as kondisi"),
			DB::raw('SUM(order_item.Jumlah * order_item.Harga) + orders.Ongkir as total')
		)
		->join('konsumen','orders.IDKonsumen','=','konsumen.IDKonsumen')
		->join('order_item','orders.IDOrder','=','order_item.IDOrder')
		->where('orders.IDOS', 3)
		->orWhere('orders.IDOS', 4)
		->groupBy('orders.IDOrder','konsumen.Nama','orders.TglPesan','orders.TglKirim','orders.IDOS','orders.Ongkir');
		
        if($result->count() != 0)
        {
            $tbl = $result->orderByDesc('TglPesan')->get();
			
			$this->table_siapKirim = json_encode($tbl);
        }

        return view('livewire.transaction-pengiriman');
    }
}
