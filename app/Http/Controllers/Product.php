<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{
    BrgJenis,
    BrgKategori,
    Brand,
    Product as Produk,
    Harga,
    Stok,
    Barang,
    BrgMasuk,
    BarangExtra,
    Fiturs,
};


class Product extends Controller
{
    public function requestExtra(Request $i)
    {
        BarangExtra::insert([
            'IDR'       => BarangExtra::getID(),
            'Ket'       => $i->input('txt'),
            'IDHarga'   => $i->input('id'),
            'Tgl'       => date('Y-m-d H:i:s',strtotime('now'))
        ]);
    }

    public function requestExtraJenis($id)
    {
        if(empty($id))
        {
            return response('harap masukkan id',500);
        }
        else
        {
            $res    = BarangExtra::find($id);
            $tujuan = '';

            switch($res->Jenis)
            {
                case 0: $tujuan = 'edit'; break;
                case 1: $tujuan = 'stok'; break;
                default:
                return response('tidak ditemukan',500);
            }

            return response()->json([
                'tujuan' => $tujuan
            ]);
        }
    }

    public function insert(Request $r)
    {
        
        $stok = Produk::getID_stok();

        $db = new Stok;

        $db->IDBrg      = $r->input('id_brg');
        $db->IDStok     = $stok;
        $db->StokKey    = $r->input('stok');
        $db->StokVal    = $r->input('stok');
        $db->save();

        $db = new Harga;
        
        $db->IDHarga    = Produk::getID_harga();
        $db->TglCreate  = date('Y-m-d H:i:s');
        $db->IDStok     = $stok;
        $db->Dsc        = $r->input('dsc');
        $db->save();
    }

    public function showId(Request $r, $id)
    {
        $db = Harga::with('getStok.getBarang')->where('IDHarga',$id)->get();

        return response()->json(['table' => $db]);
    }

    public function update(Request $r)
    {
        $harga  = Harga::find($r->input('id'));
        $idStok = $harga->IDStok;

        $harga->HargaJual      = $r->input('hargaJual');
        $harga->Dsc            = $r->input('dsc');
        $harga->TglUpdate      = date('Y-m-d H:i:s',strtotime('now'));

        if(Fiturs::first()->barangEvt)
        {
            $harga->IDBrgEvt = $r->input('event');
        }

        $stok       = Stok::where('IDStok',$idStok)->with('getBarang','getBarang.getJenis')->first();
        $id_old     = $stok->getBarang->IDBrg;
        $brgJenis   = BrgJenis::find($stok->getBarang->IDBrgJenis);


        if($brgJenis->IDBrgJenis != $r->input('jenis'))
        {
            $brg                = Barang::where('IDBrg', $stok->getBarang->IDBrg)->first();
            $id_brg             = Produk::getID_barang();

            $newBrg             = new Barang;
            $newBrg->IDBrg      = $id_brg;
            $newBrg->KodeBrg    = $brg->KodeBrg;
            $newBrg->Nama       = $brg->Nama." new";
            $newBrg->ShortName  = $brg->ShortName;
            $newBrg->IDBrgJenis = $r->input('jenis');
            $newBrg->save();

            $new                = Stok::find($harga->IDStok);
            $new->IDBrg         = $id_brg;
            $new->TglUpdate     = date('Y-m-d H:i:s',strtotime('now'));
            $new->save();

            $raw = Barang::where('IDBrg',$id_old)->with('getStok')->first();

            if(empty($raw->getStok))
            {
                Barang::destroy($id_old);
                unset($id_old, $new, $raw, $newBrg, $brgJenis);
            }
        }
        $harga->save();
    }

    public function delete(Request $r)
    {
        $h = Harga::where('IDHarga', $r->input('id'));

        if($h->count() == 1)
        {
            
            $ids = $h->first();

            $m = BrgMasuk::where('IDHarga', $ids->IDHarga);

            if($m->count() == 1)
            {
                $m->delete();
            }

            $h->delete();

            $stok = Stok::where('IDStok', $ids->IDStok);

            if($stok->count() == 1)
            {
                $id = $stok->first();

                $stok->delete();

                Barang::where('IDBrg', $id->IDBrg)->delete();
            }
        }
    }

    public function update_harga(Request $r)
    {
        $db = Harga::find($r->input('id'));
        
        $db->HargaJual = $r->input('jual');
        $db->HargaBeli = $r->input('beli');

        $db->save();
    }
    

    public function getAll()
    {
        $res = DB::table('barang_harga')->select([
            'barang_harga.IDHarga',
            'barang_harga.Icon',
            'barang.Nama',
            'barang_harga.HargaJual',
            'barang_jenis.Nama as jenis',
            'barang_kategori.Nama as kategori',
            'barang_brand.Nama as brand'
        ])
        ->join('barang_stok', function($join){
            return $join->on('barang_harga.IDStok','=','barang_stok.IDStok')
                        ->whereRaw('barang_stok.StokVal >= barang_harga.Dsc');
        })
        ->join('barang','barang_stok.IDBrg','=','barang.IDBrg')
        ->join('barang_jenis','barang.IDBrgJenis','=','barang_jenis.IDBrgJenis')
        ->join('barang_kategori','barang_jenis.IDBrgKategori','=','barang_kategori.IDBrgKategori')
        ->join('barang_brand','barang_kategori.IDBrand','=','barang_brand.IDBrand')
        ->get();

        return response()->json([
            'data' => $res
        ]);
    }

    public function getJenis(Request $r, $id)
    {
        $db   = BrgJenis::where('IDBrgKategori',$id)->get();
        $data = [];

        if(!empty($db))
        {
            $data = $db;
        }

        return response()->json([
            'table' => $data
        ]);
    }

    public function getJenis_all()
    {
        return response()->json([
            'table' => BrgJenis::all()
        ]);
    }

    public function getKategori(Request $r, $id)
    {
        $db     = BrgKategori::where('IDBrand',$id)->get();
        $data   = [];

        if(!empty($db))
        {
            $data = $db;
        }

        return response()->json([
            'table' => $data
        ]);
    }

    public function getKategori_all()
    {
        return response()->json([
            'table' => BrgKategori::get()
        ]);
    }

    public function getBarang(Request $r, $id)
    {
        $db     = Barang::where('IDBrgJenis',$id)->get();
        $data   = [];

        if(!empty($db)){
            $data = $db;
        }

        return response()->json([
            'table' => $data
        ]);
    }

    public function getEvent()
    {
        return response()->json([
            'table' => \App\EventList::all()
        ]);
    }

    public function piutang()
    {
        $res = DB::table('orders')->select(
            'orders.IDOrder',
            'orders.TglPesan',
            'konsumen.Nama as konsumen',
            DB::raw('(sum(order_item.Jumlah * order_item.Harga) + orders.Ongkir) as total'),
            DB::raw("(sum(order_item.Jumlah * order_item.Harga) + orders.Ongkir) - (select SUM(order_piutang.Bayar) from order_piutang where order_piutang.IDOrder = orders.IDOrder) as hutang")
        )
        ->join('order_item','orders.IDOrder','=','order_item.IDOrder')
        ->join('konsumen', 'orders.IDKonsumen', '=', 'konsumen.IDKonsumen')
        ->groupBy('orders.IDOrder','orders.TglPesan','konsumen.Nama','orders.Ongkir','orders.Bayar')
        ->orderBy('orders.TglPesan')
        ->whereRaw("orders.IDOMe = '7xH366'")->get();

        return response()->json(['data' => $res]);
    }

    public function pembelian()
    {
        $res = DB::table('barang_pembelian')->select(
            'barang_pembelian.IDP',
            DB::raw("DATE_FORMAT(barang_pembelian.Tgl,'%d-%m-%Y') as Tgl"),
            DB::raw('(barang_pembelian.Biaya + barang_pembelian.BiayaLain) as total')
        )
        ->orderBy('barang_pembelian.Tgl','DESC')
        ->get();
        
        return response()->json(['data' => $res]);
    }
}