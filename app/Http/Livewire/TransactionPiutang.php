<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Helper\common;
use App\OrderPiutang;
use App\Orders;

class Transactionpiutang extends Component
{
    public $itemOrder, $maxBayar, $inputBayar = 0;
    public $kurang = 0, $kembalian = 0, $prosesStatus = 0;


    public function initModalPembayaran($idItem)
    {
        if($idItem != '')
        {
            $db     = Orders::where('IDOrder', $idItem)->first();
            $pu     = OrderPiutang::where('IDOrder',$idItem)->get();
            $bayar  = 0;
            $max    = (common::totalOrder($idItem) + $db->Ongkir) - (collect($pu)->sum('Bayar'));

            $this->itemOrder = $idItem;
            $this->maxBayar  = $max;

            $this->emit('show-pembayaran');
        }
    }

    public function perhitungan()
    {
        $hasil = $this->inputBayar - $this->maxBayar;
        
        if($this->inputBayar < $this->maxBayar)
        {
            $this->fill([
                'kembalian' => 0,
                'kurang'    => number_format($this->maxBayar - $this->inputBayar,0,",",".")
            ]);
        }
        else
        {
            $this->fill([
                'kurang'    => 0,
                'kembalian' => number_format($hasil,0,",",".")
            ]);
        }
		
		$this->prosesStatus = 1;
    }

    public function pembayaran()
    {
        $db = new OrderPiutang;

        $db->IDOPi      = OrderPiutang::getIDPiutang();
        $db->IDOrder    = $this->itemOrder;
        $db->Bayar      = $this->inputBayar;
        $db->TglByr     = date('Y-m-d H:i:s',strtotime('now'));

        $db->save();

        $piutang= OrderPiutang::select('Bayar')->where('IDOrder',$this->itemOrder);
        
        if($piutang->count() != 0)
        {
            $check = Orders::where('IDOrder', $this->itemOrder)->first();
            $hutang= $piutang->get();
            $total = (common::totalOrder($this->itemOrder) + $check->Ongkir);

            if($total <= (collect($hutang)->sum('Bayar')))
            {
                $o = Orders::find($this->itemOrder);
                $o->IDOMe = 0;
                $o->save();
            }
        }

        $this->emit('close-pembayaran');
        $this->render();
    }

    
    public function render()
    {
        return view('livewire.transaction-piutang');
    }
}
