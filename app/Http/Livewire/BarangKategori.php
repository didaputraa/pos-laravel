<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\BrgKategori as Kategori;
use App\Product;
use App\Brand;


class Barangkategori extends Component
{
    public $nmAdd = '', $nmEdit = '',$brandAdd = '', $brandEdit = '';
    public $idEdit, $idDel;


    public function store()
    {
        if($this->nmAdd != '' && $this->brandAdd != '')
        {
            $db = new Kategori;
            
            $db->IDBrgKategori = Product::getID_kategori();
            $db->Nama       = $this->nmAdd;
            $db->IDBrand    = $this->brandAdd;
            $db->save();

            $this->render();

            $this->nmAdd    = '';
            $this->brandAdd = '';

            $this->emit('md-add-close');
        }
    }

    public function update()
    {
        if($this->idEdit != '')
        {
            $db = Kategori::find($this->idEdit);
            $db->Nama   = $this->nmEdit;
            $db->IDBrand= $this->brandEdit;
            $db->save();

            $this->emit('md-edit-close');

            $this->nmEdit   = '';
            $this->brandEdit= '';
            $this->idEdit   = '';
        }
    }

    public function remove()
    {
        Kategori::destroy($this->idDel);

        $this->idDel = '';
        $this->emit('md-del-close');
    }

    

    public function initDel($id)
    {
        if(!empty($id))
        {
            $this->idDel = $id;

            $this->emit('md-del');
        }
    }

    public function initEdit($id)
    {
        if($id != '')
        {
            $res = Kategori::where('IDBrgKategori',$id)->first();

            if(!empty($res))
            {
                $this->nmEdit       = $res->Nama;
                $this->brandEdit    = $res->getBrand->IDBrand;
                $this->idEdit       = $res->IDBrgKategori;

                $this->emit('md-edit');
            }
        }
    }

    public function render()
    {
        return view('livewire.barang-kategori',[
            'table'       => Kategori::all(),
            'table_brand' => Brand::all()
        ]);
    }
}
