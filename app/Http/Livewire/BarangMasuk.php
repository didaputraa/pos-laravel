<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\{
    BrgKategori,
    BrgJenis,
    Barang,
    Harga,
    Stok,
    Product,
    BrgMasuk
};

class Barangmasuk extends Component
{
    use WithFileUploads;

    public $pageActive = 'input', $idItem = '';
    public $photo, $brand, $jenis, $kategori, $nama, $shrNama, $stok = 0;

    
    public function switchTo($to = '')
    {
        $this->pageActive = $to;

        return redirect("/product/barang-masuk/?act={$to}");
    }
	
	public function removeItem()
	{
		BrgMasuk::whereRaw("month(TglMasuk) != month(CURDATE())")->delete();
	}

    public function getKategori($idItem)
    {
        if($idItem != '')
        {
            $this->tbl_kategori = BrgKategori::where('IDBrand', $idItem)->get();
        }
    }

    public function getJenis($idItem)
    {
        if($idItem != '')
        {
            $this->tbl_jenis = BrgJenis::where('IDBrgKategori', $idItem)->get();
        }
    }

    public function hapus()
    {
        if($this->idItem != '')
        {
            BrgMasuk::where('IDBrgMasuk', $this->idItem)->delete();
        }

        $this->emit('close-hapus');
    }

    public function StoreBarang()
    {
        $this->validate([
            'nama'      => 'required',
            'shrNama'   => 'required',
            'jenis'     => 'required',
            'kategori'  => 'required',
            'brand'     => 'required',
            'photo'     => 'image|max:1024',
        ]);

        $photo = $this->photo->store('upload');
            
        /** barang  **/
            $b      = new Barang;
            $idBrg  = Product::getID_barang();

            $b->IDBrg       = $idBrg;
            $b->KodeBrg     = '-';
            $b->Nama        = $this->nama;
            $b->ShortName   = $this->shrNama;
            $b->IDBrgJenis  = $this->jenis;
            $b->save();
            
        /** barang stok **/
            $s      = new Stok;
            $idStok = Product::getID_stok();

            $s->IDStok  = $idStok;
            $s->StokKey = $this->stok;
            $s->StokVal = $this->stok;
            $s->IDBrg   = $idBrg;
            $s->save();

        /** barang harga **/
            $h      = new Harga;
            $idHarga= Product::getID_harga();

            $h->IDHarga     = $idHarga;
            $h->IDStok      = $idStok;
            $h->Dsc         = 0;
            $h->Icon        = $photo;
            $h->TglCreate   = date('Y-m-d H:i:s', strtotime('now'));
            $h->save();

        /** barang masuk **/
            $m = new BrgMasuk;
            $m->IDBrgMasuk  = Product::getID_barangMasuk();
            $m->Jumlah      = $this->stok;
            $m->IDHarga     = $idHarga;
            $m->TglMasuk    = date('Y-m-d H:i:s',strtotime('now'));
            $m->save();

        return redirect("/product/barang-masuk/?act=view");
    }

    public function render()
    {
		$this->removeItem();
		
		$res = [];

        if(request()->query('act') == 'view')
        {
            $this->pageActive = 'view';
            $res = BrgMasuk::with('getHarga.getStok.getBarang')->get();
        }
        elseif(request()->query('act') == 'input')
        {
            $this->pageActive = 'input';
            $res = \App\Brand::all();
        }

        return view('livewire.barang-masuk', [
            'tbl_data' => $res
        ]);
    }
}
