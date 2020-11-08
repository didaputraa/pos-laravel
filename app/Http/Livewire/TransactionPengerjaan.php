<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Orders;
use App\OrderItem;

class Transactionpengerjaan extends Component
{
    public $itemOrder;
    public $table_item   = [];
    public $table_item_s = 0;
    public $max_working  = 0, $item_working, $inputJml = 0;


    public function initWorking($id)
    {
        if($id != '')
        {
            $this->itemOrder = $id;

            $result = $this->getItem($id);

            if(empty($result))
            {
                $this->table_item_s = 0;
            }
            else
            {
                $this->table_item = $result;
    
                $this->table_item_s = 1;

                $this->emit('show-working');
            }
        }
    }

    public function getMaxWorking($id)
    {
        if($id != '')
        {
            $this->item_working = $id;
            $this->max_working  = OrderItem::selectRaw('Jumlah - Terproses as max')->where('IDOItem',$id)->first()->max;

            $this->emit('show-working-jml');
        }
    }

    public function proccessWorking()
    {
        if($this->item_working != '')
        {
            $today = date('Y-m-d H:i:s', strtotime('now'));
            $tmp   = [];

            $db = OrderItem::find($this->item_working);
            $db->Terproses     += $this->inputJml;
            $db->TglTerproses   = $today;
            $db->TglPengerjaan  = $today;
            $db->save();

            $item = $this->getItem($this->itemOrder);

                foreach($item as $row)
                {
                    $res = \App\Helper\common::minWorking($row->sum('Jumlah'), $row->sum('Terproses'));
                    
                    if($res == 'Selesai')
                    {
                        $tmp[]  = $res;
                    }
                }

                if(count($item) == count($tmp))
                {
                    $o = Orders::find($this->itemOrder);
                    $o->IDOS = 3; //pengiriman
                    $o->save();
                }

            $this->inputJml     = 0;
            $this->table_item   = $item;

            $this->emit('close-working-jml');
        }
    }

    public function getItem($id)
    {
        $sql                = OrderItem::where('IDOrder', $id);
        $this->itemOrder    = $id;

        if($sql->count() != 0)
        {
            return $sql->get();
        }
        return [];
    }



    public function render()
    {
        $tbl = [];

        $order = Orders::where('IDOS',5)->where('Status',1)->where('IDOMe','!=','7xH366');

        if($order->count() != 0)
        {
            $tbl = $order->get();
        }

        return view('livewire.transaction-pengerjaan',[
            'table_working' => $tbl
        ]);
    }
}
