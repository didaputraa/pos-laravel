<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Harga;
use App\Stok;


class Barangstok extends Component
{
    public $stokAwal = 0,$stokAkhir = 0;
    public $item, $item_del;


    public function initEdit($id)
    {
        if($id != '')
        {
            $db = Stok::where('IDStok',$id)->first();

            if(!empty($db))
            {
                $this->stokAwal = $db->StokKey;
                $this->stokAkhir= $db->StokVal;
                $this->item     = $db->IDStok;
    
                $this->emit('modal-edit');
            }
        }
    }
    
    public function update()
    {
        if($this->item != '')
        {
            $db = Stok::find($this->item);
            $db->StokKey = $this->stokAwal;
            $db->StokVal = $this->stokAkhir;
            $db->save();

            $this->stokAwal = '';
            $this->stokAkhir= '';
            $this->item     = '';

            $this->emit('modal-edit-close');
            $this->render();
        }
    }

    public function initDel($id)
    {
        if($id != '')
        {
            $db = Stok::where('IDStok',$id)->first();

            if(!empty($db))
            {
                $this->item_del = $db->IDStok;

                $this->emit('modal-del');
            }
        }
    }

    public function delete()
    {
        if($this->item_del != '')
        {
            $db = Stok::find($this->item_del);
            
            $db->StokKey = 0;
            $db->StokVal = 0;
            $db->save();

            $this->item_del = '';
            $this->emit('modal-del-close');
            $this->render();
        }
    }

    public function initRequestStok($idItem)
    {
        if($idItem != '')
        {
            $this->item = $idItem;
        }

        $this->emit('show-request-extra');
    }

    public function prosesRequest()
    {
        \App\BarangExtra::insert([
            'IDR'       => \App\BarangExtra::getID(),
            'IDHarga'   => $this->item,
            'Jenis'     => 1,
            'Tgl'       => date('y-m-d H:i:s',strtotime('now')),
            'Ket'       => '-'
        ]);

        $this->idItem = '';

        $this->emit('close-request-extra');
    }

    public function render()
    {
        return view('livewire.barang-stok',[
            'table' => Harga::all()
        ]);
    }
}
