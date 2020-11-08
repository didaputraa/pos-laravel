<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use App\{
    Barang,
    BarangExtra as extra,
    Brand,
    BrgJenis,
    BrgKategori,
    Harga,
    EventList,
    Fiturs,
    Stok,
    BrgMasuk,
    Product
};

class Barangrequestextra extends Component
{
    use WithFileUploads;

    public $act, $tbl = '', $tblEdit = '', $idItem = '', $ids = 0;
    public $photo, $nm, $nm_short, $kodeBrg, $jenis, $itemEvent;
    public $itemBrand = '', $itemKategori = '', $itemJenis = '', $tujuan;
    public $tbl_kategori = [], $tbl_jenis =[], $tbl_event = [];
    public $stok = ['jml' => '', 'id' => ''];
    


    public function initTujuan($idItem = '')
    {
        if($idItem != '')
        {
            $res = extra::where('IDR', $idItem)->first();

            if($res->Jenis == 1)
            {
                $this->fill(['tujuan' =>'stok']);
            }
            else
            {
                $this->fill(['tujuan' => 'edit']);
            }
        }
    } 

    public function initEdit($idItem = '')
    {
        if($idItem != '')
        {
            $this->act      = 'edit';
            $this->idItem   = $idItem;
        }
    }

    public function changeKategori()
    {
        $this->tbl_kategori = BrgKategori::where('IDBrand', $this->itemBrand)->get();
    }

    public function changeJenis()
    {
        $this->tbl_jenis = BrgJenis::where('IDBrgKategori', $this->itemKategori)->get();
    }

    public function simpan()
    {
        $extra = extra::where('IDR', $this->idItem)->first();

        $h = Harga::find($extra->getHarga->IDHarga);
        
        if($this->photo != '')
        {
            $this->validate([
                'photo' => 'image|max:1024',
            ]);
            
            $h->Icon = $this->photo->store('upload');
        }

        if(Fiturs::first()->barangEvt)
        {
            $h->IDBrgEvt = $this->itemEvent;
        }

        $h->save();

        /** barang **/
        $b = Barang::find($extra->getHarga->getStok->IDBrg);

        $b->KodeBrg     = $this->kodeBrg;
        $b->Nama        = $this->nm;
        $b->ShortName   = $this->nm_short;
        $b->IDBrgJenis  = $this->itemJenis;
        $b->save();

        unset($extra);

        /** destroy request **/
        extra::destroy($this->idItem);

        $this->emit('close-konfirmasi');
    }

    public function batal()
    {

    }

    public function stokRequest()
    {
        $stok = $this->stok['jml'];
        $s    = Stok::find($this->stok['id']);

        BrgMasuk::create([
            'IDBrgMasuk'  => Product::getID_barangMasuk(),
            'Jumlah'      => $stok,
            'IDHarga'     => $s->getHarga->IDHarga,
            'TglMasuk'    => today()
        ]);

        $key = $s->StokKey >  ($s->StokVal + $stok)? $s->StokKey : $s->StokKey + (($s->StokVal + $stok) - $s->StokKey);

        $s->StokKey = $key;
        $s->StokVal += $stok;
        $s->save();

        $this->stok = '';

        extra::where('IDR',request()->query('id'))->delete();
        
        $this->emit('redirect','view');
    }

    public function render()
    {
        $req = request()->query('act');
        $data= [];

        if($req == 'view')
        {
            $this->tbl = json_encode(extra::with('getHarga.getStok.getBarang.getJenis.getKategori')->get());
            $this->act = 'view';
        }
        elseif($req == 'edit')
        {
            $fitur = Fiturs::first();
            $data  = [
                'tbl_brand'  => Brand::all(),
                'fiturs'     => $fitur
            ];

            if($this->ids == 0)
            {
                $this->tblEdit      = extra::where('IDR', request()->query('id'))->first();
                
                if($fitur->barangEvt)
                {
                    $this->tbl_event = EventList::all();
                }

                $this->nm           = $this->tblEdit->getHarga->getStok->getBarang->Nama;
                $this->nm_short     = $this->tblEdit->getHarga->getStok->getBarang->ShortName;
                $this->kodeBrg      = $this->tblEdit->getHarga->getStok->getBarang->KodeBrg;
                $this->itemEvent    = $this->tblEdit->getHarga->IDBrgEvt;

                $this->itemBrand    = $this->tblEdit->getHarga->getStok->getBarang->getJenis->getKategori->getBrand->IDBrand;
                $this->itemJenis    = $this->tblEdit->getHarga->getStok->getBarang->getJenis->IDBrgJenis;
                $this->itemKategori = $this->tblEdit->getHarga->getStok->getBarang->getJenis->getKategori->IDBrgKategori;

                $this->changeKategori();
                $this->changeJenis();

                $this->ids = 1;
            }

            $this->idItem   = request()->query('id');
            $this->act      = 'edit';
        }
        elseif($req == 'stok')
        {
            $this->act = 'stok';
            
            $res = extra::find(request()->query('id'));
            
            if(!empty($res->IDHarga))
            {
                if($this->stok['id'] == '')
                {
                    $res = Harga::where('IDHarga',$res->IDHarga)->first();

                    $this->stok['id'] = $res->getStok->IDStok;
                }
            }
        }

        return view('livewire.barang-request-extra',$data);
    }
}
