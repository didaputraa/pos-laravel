<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Orders;
use App\OrderItem;
use App\Harga;
use App\OrderPiutang;

class Transactionpembayaran extends Component
{
    public $orderID_old, $inputUser_old = 0;

    public $debet = 0, $orderID, $inputUser = 0;

    public function showKonfirmasi($id, $total)
    {
        $this->fill([
            'orderID'  => $id,
            'debet'    => $total,
            'inputUser'=> 0
        ]);

        $this->emit('show-konfirmasi');
    }

    public function bayar()
    {
        if($this->orderID != '')
        {
            $tunai = '7ftKKb';

            if($this->debet > $this->inputUser) // hutang
            {
                $tunai = '7xH366';

                OrderPiutang::create([
                    'IDOPi'     => OrderPiutang::getIDPiutang(),
                    'IDOrder'   => $this->orderID,
                    'Bayar'     => $this->inputUser,
                    'TglByr'    => Carbon::now()
                ]);
            }

            $db = Orders::find($this->orderID);

            $db->Bayar = $this->inputUser;
            $db->IDOMe = $tunai;
            $db->IDOS  = 5;

            $db->save();
        }

        $this->emit('close-pembayaran');
        $this->render();
    }

    public function batalBeli()
    {
        OrderItem::where('IDOrder', $this->orderID)->delete();
        
        Orders::where('IDOrder',$this->orderID)->delete();

        $this->orderID = '';

        $this->emit('close-pembatalan');
        $this->render();
    }

    public function render()
    {
        $tbl    = [];
        $result = DB::table('orders')
        ->select(
            'orders.IDOrder','orders.TglPesan', 'konsumen.Nama as konsumen',
            DB::raw('SUM(order_item.Harga * order_item.Jumlah) + orders.Ongkir as total')
        )
        ->join('konsumen','orders.IDKonsumen','=','konsumen.IDKonsumen')
        ->join('order_item','orders.IDOrder','=','order_item.IDOrder')
        ->where("orders.IDOS", 2)
        ->groupBy('orders.IDOrder','orders.TglPesan','konsumen.Nama','exam_pos.orders.Ongkir')
        ->orderBy('orders.TglPesan','DESC');

        if($result->count() != 0)
        {
            $tbl = $result->get();
        }

        return view('livewire.transaction-pembayaran',[
            'table_pembayaran' => $tbl
        ]);
    }
}
