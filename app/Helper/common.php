<?php
namespace App\Helper;

class common
{
    public static function getPercen_working($id)
    {
        $map = collect(\App\OrderItem::where('IDOrder',$id)->get());

        $jml = $map->sum('Jumlah');
        $pro = $map->sum('Terproses');

        if($jml == 0 && $pro == 0)
        {
            return 0;
        }
        else
        {
            return round($pro / $jml * 100, 2);
        }
    }

    public static function minWorking($jml, $selesai)
    {
        if($jml - $selesai == 0)
        {
            return 'Selesai';
        }
        
        return $jml - $selesai;
    }

    public static function totalOrder($id)
    {
        $map = collect(\App\OrderItem::where('IDOrder', $id)->get());

        $res = $map->sum(function($item){
            return $item['Jumlah'] * $item['Harga'];
        });

        return $res;
    }

}