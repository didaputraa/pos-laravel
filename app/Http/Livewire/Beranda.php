<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\{
	Orders,
	BrgMasuk,
	Piutang,
	Konsumen,
	Harga as Product
};

class Beranda extends Component
{
	private function orderan()
	{
		return DB::table('orders')->select(
			'konsumen.Nama',
			DB::raw('(select SUM(Jumlah) from order_item where IDOrder = orders.IDOrder) as jumlah'),
			DB::raw('(select SUM(Jumlah * Harga) from order_item where IDOrder = orders.IDOrder) + orders.Ongkir as total')
		)
		->join('konsumen', 'orders.IDKonsumen','=','konsumen.IDKonsumen')
		->where('orders.IDOS', 4)
		->whereRaw('DATE(orders.TglPesan) = CURDATE()')
		->orderBy('orders.TglPesan');
	}
	
	private function grafixOrder()
	{
		$res = DB::table('orders')->select(
			DB::raw('MONTH(TglPesan) as bulan'),
			DB::raw('(select SUM(Jumlah) from order_item where IDOrder = orders.IDOrder) as jumlah')
		)
		->where('orders.IDOS', 4)
		->whereRaw('YEAR(NOW())')
		->orderByRaw('Month(orders.TglPesan)')
		->get();
		
		return ($res);
	}
	
    public function render()
    {
		$data['barang_in']	= BrgMasuk::count();
		
		$data['piutang'] 	= Orders::where('IDOMe', '7xH366')->count();
		
		$data['konsumen'] 	= Konsumen::count();
		
		$data['produk']		= Product::count();
		
		$data['orderan']	= $this->orderan();
		
		
		$grafix = collect($this->grafixOrder());
		$tmp	= [];
		
		$bulan  = $grafix->mapToGroups(function($v){
			$b  = 0;
			
			switch($v->bulan)
			{
				case 1: $b = 'Januari';  	break;
				case 2: $b = 'Februari'; 	break;
				case 3: $b = 'Maret';  		break;
				case 4: $b = 'April';  		break;
				case 5: $b = 'Mei';  		break;
				case 6: $b = 'Juni';  		break;
				case 7: $b = 'Juli';  		break;
				case 8: $b = 'Agustus';  	break;
				case 9: $b = 'September';  	break;
				case 10: $b = 'Oktober';  	break;
				case 11: $b = 'November';  	break;
				case 12: $b = 'Desember';  	break;
			}
			
			return ['bln' => $b];
			
		})->get('bln')->unique()->values()->all();
		
		$maps  = $grafix->mapToGroups(function($v){
			
			return [$v->bulan => $v->jumlah];
			
		});
		
		foreach($maps as $i => $r)
		{
			$tmp[$i] = collect($r)->sum();
		}
		
		$data['bulanData']  = json_encode(collect($tmp)->values()->all());
		$data['bulan'] 		= json_encode($bulan);
		$data['pengerjaan'] = json_encode(Orders::where('IDOS', 5)->count());
		
		return view('livewire.beranda',$data);
    }
}
