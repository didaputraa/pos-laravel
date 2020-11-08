<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Resep;


class BahanBaku extends Controller
{

    public function showById(Request $r, $id)
    {
        $db = [];
        $res= Resep::where('IDBPR',$id)->get();
        
        if(!empty($res))
        {
            $db = $res;
        }

        return response()->json(['table' => $db]);
    }

    public function insert_item(Request $r)
    {
        $json = json_decode($r->input('inputan'));
        $tmp  = [];
        $biaya= 0;
        $i    = 1;

        foreach($json as $row)
        {
            if($row->label != '' && $row->biaya != '')
            {
                $tmp[] = [
                    'id'    => $i,
                    'label' => $row->label,
                    'biaya' => $row->biaya
                ];
                $biaya += $row->biaya;
                $i++;
            }
        }


        $db = Resep::find($r->input('id'));

        $db->RincianItem = json_encode($tmp);
        $db->Biaya       = $biaya;
        $db->save();
    }

    public function remove_item(Request $r)
    {
        $id     = Resep::where('IDBPR',$r->input('id'))->first();
        $data   = json_decode($id->RincianItem,true);
        $biaya  = 0;
        $result = [];
        $new    = '';
        
        print_r($data);

        if(is_array($data))
        {
            $new= Arr::where($data, function($row) use($r){
                return $row['id'] != $r->input('idItem');
            });
        }

        if(empty($new))
        {
            $new = "-";
        }
        else
        {
            foreach($new as $row)
            {
                $biaya += $row['biaya'];
            }
            $new = json_encode($new);
        }

        $db = Resep::find($r->input('id'));
        $db->RincianItem = $new;
        $db->Biaya       = $biaya;
        $db->save();
    }

    public function insert(Request $r)
    {
        $db = new Resep;

        $db->Label      = $r->input('label');
        $db->Biaya      = $r->input('biaya');
        $db->BiayaLain  = $r->input('biaya_lain');
        $db->TglCreate  = date('Y-m-d H:i:s');
        $db->save();
    }

    public function remove(Request $r)
    {
        Resep::destroy($r->input('item'));
    }

    public function update(Request $r)
    {
        $db = Resep::find($r->input('id'));

        $db->Label     = $r->input('label');
        $db->BiayaLain = $r->input('biayaLain');

        $db->save();
    }

    public function update_item(Request $in)
    {
        $i      = 0;
        $json   = [];
        $rincian= '-';
        $biaya  = 0;

        foreach(json_decode($in->input('inputan')) as $re)
        {
            if($re->label != '' && $re->biaya != '')
            {
                $json[] = [
                    'id'    => $i,
                    'label' => $re->label,
                    'biaya' => $re->biaya
                ];
                $biaya += $re->biaya;
                $i++;
            }
        }

        if(is_array($json))
        {  
            $rincian = json_encode($json);
        }

        
        $r = Resep::find($in->input('id'));

        $r->RincianItem = $rincian;
        $r->Biaya       = $biaya;

        $r->save();
    }
}