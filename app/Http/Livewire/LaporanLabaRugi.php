<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Orders;
use App\Pembelian;
use Illuminate\Support\Facades\DB;

class Laporanlabarugi extends Component
{
    public function pem()
    {

    }

    public function render()
    {
        $res1 = DB::table('orders')->select(
            DB::raw('Month(orders.TglPesan) as bulan'),
            DB::raw('sum((order_item.Harga - barang_harga.HargaBeli)*order_item.Jumlah) as penjualan')
        )->join('order_item','orders.IDOrder', '=','order_item.IDOrder')
        ->join('barang_harga','order_item.IDHarga', '=','barang_harga.IDHarga')
        ->whereRaw("Year(CURDATE()) = ".date('Y',strtotime('now')))
        ->groupByRaw('Month(TglPesan) ASC')->get();

        $col = collect($res1)->mapToGroups(function($o)
        {
            return ['bulan' =>$o->bulan];
        })->get('bulan');

        $tmp  = [];

        foreach($col->all() as $r)
        {
            $tmp[] = ["bulan" => $r, "pembelian" => 0];
        }

        $res2 = (array)Pembelian::select(
            DB::Raw('Month(Tgl) as bulan'),
            DB::Raw('sum(Biaya+BiayaLain) as pembelian')
        )->whereRaw("Month(Tgl) in({$col->implode(',')}) && Year(CURDATE()) = ".date('Y',strtotime('now')))
        ->groupByRaw('Month(Tgl) ASC')->get();
        
        foreach($tmp as $i)
        {
            array_push($res2["\x00*\x00items"], $i);
        }

        $res2 = collect($res2["\x00*\x00items"])->unique('bulan')->sort()->values()->all();

        return view('livewire.laporan-labarugi',[
            'penjualan' => $res1,
            'pembelian'=> json_encode($res2),
            'bulan' => $col->implode(',')
        ]);
    }
}
