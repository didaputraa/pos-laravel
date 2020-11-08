<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Product;
use App\BrgJenis;
use App\BrgKategori;
use App\Brand;


class Barangjenis extends Component
{
    public $nmAdd, $nmEdit, $brandAdd;
    public $idDel, $idEdit, $brandEdit;
    public $kategoriAdd, $kategoriEdit,
           $table_kategori      = [],
           $table_kategori_edit = [],
           $table_brand_edit    = [];


    public function store()
    {
        if($this->nmAdd != '' && $this->kategoriAdd != '')
        {
            $db = new BrgJenis;
            $db->IDBrgJenis     = Product::getID_jenis();
            $db->Nama           = $this->nmAdd;
            $db->IDBrgKategori  = $this->kategoriAdd;
            $db->save();

            $this->nmAdd        = '';

            $this->render();
            $this->emit('md-add-close');
        }
    }

    public function update()
    {
        if($this->idEdit != '')
        {
            $db = BrgJenis::find($this->idEdit);
            $db->Nama           = $this->nmEdit;
            $db->IDBrgKategori  = $this->kategoriEdit;
            $db->save();

            $this->emit('md-edit-close');

            $this->nmEdit       = '';
            $this->kategoriEdit = '';
        }
    }

    public function remove()
    {
        if($this->idDel != '')
        {
            BrgJenis::destroy($this->idDel);

            $this->emit('md-del-close');

            $this->idDel = '';
        }
    }


    public function initEdit($id)
    {
        $db = BrgJenis::where('IDBrgJenis', $id)->first();

        if(!empty($db))
        {
            $this->table_kategori_edit  = BrgKategori::where('IDBrand',$db->getKategori->IDBrand)->get();
            $this->table_brand_edit     = Brand::all();

            $this->nmEdit               = $db->Nama;
            $this->kategoriEdit         = $db->IDBrgKategori;
            $this->idEdit               = $db->IDBrgJenis;

            $this->emit('md-edit');
        }
    }

    public function initDel($id)
    {
        $this->idDel = $id;

        $this->emit('md-del');
    }

    public function initBrand()
    {
        $res = BrgKategori::where('IDBrand',$this->brandAdd)->get();

        $this->table_kategori = $res;
        $this->kategoriAdd    = $res[0]->IDBrgKategori;
    }

    public function initBrandEdit()
    {
        if($this->brandEdit != '')
        {
            $res = BrgKategori::where('IDBrand',$this->brandEdit)->get();

            $this->table_kategori_edit = $res;
        }
    }

    public function render()
    {
        return view('livewire.barang-jenis',[
            'table'          => BrgJenis::all(),
            'table_brand'    => Brand::all(),
        ]);
    }
}
