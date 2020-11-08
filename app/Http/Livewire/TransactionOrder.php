<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\{
    Konsumen,
    Orders,
    OrderItem,
    Harga,
    Ekspedisi,
    Fiturs
};

class Transactionorder extends Component
{
    public $errMsg, $hargaID;

    public $page_active, $btn_active, $jumlah, $total = 0, $maxInputJml = 1;
    
    public $select_customer, $customer_name;

    public $table_cus, $table_item, $item_remove, $item_update;

    public $orderCancel, $ekspedisi = 0, $deadline, $ongkir = 0;
    

    public function backOrder($btn = 'order',$page = 'order')
    {
        $this->page_active  = $page;
        $this->btn_active   = $btn;

        $this->render();
        $this->mount();
    }

    public function initSelect()
    {
        $this->page_active = 'select-customer';
        $this->btn_active  = '';
    }

    public function initSelectBarang()
    {
        $this->page_active = 'barang';
        $this->btn_active  = '';
    }

    public function changeOngkir()
    {
        if($this->ekspedisi != '')
        {
            $res = Ekspedisi::find($this->ekspedisi);
            $this->ongkir = $res->Tarif;
        }
    }

    public function selectCustomer($id)
    {
        $cus = Konsumen::where('IDKonsumen', $id)->first();

        $this->select_customer = $id;
        $this->customer_name   = $cus->Nama;
        
        $this->initCustomer();

        $this->page_active     = 'order';
        $this->btn_active      = 'barang';
    }

    public function initCustomer()
    {
        $db         = new Orders;
        $ids        = Orders::getIDOrder();
        
        $db->IDOrder        = $ids;
        $db->NoResi         = Orders::getNoResi();
        $db->NoFaktur       = Orders::getNoFaktur();
        $db->TglPesan       = date('Y-m-d H:i:s',strtotime('now'));
        $db->IDKonsumen     = $this->select_customer;
        $db->Capture        = '';
        $db->IDEkspedisi    = 0;

        $db->save();
        
        $this->mount();
    }

    public function setMaxInput($id)
    {
        if($id != '')
        {
            $res = Harga::with('getStok')->where('IDHarga',$id)->first();

            if(!empty($res))
            {
                if(!empty($res->Dsc))
                {
                    $round = ceil($res->getStok->StokVal / $res->Dsc);

                    if($round - 1 == 0)
                    {
                        $this->maxInputJml = $round;
                    }
                    else
                    {
                        $this->maxInputJml = $round-1;
                    }
                }
                else
                {
                    $this->errMsg = json_encode(['dsc' => $res->Dsc]);
                    $this->emit('err-terjadi');
                }
            }
            else
            {
                $this->errMsg = json_encode(['ceil' => $res]);
                $this->emit('err-terjadi');
            }
        }
    }

    public function initBarang($jumlah, $idHarga)
    {
		if($idHarga != '')
		{
			$order = Orders::where('IDOS',6)->where('IDKonsumen', $this->select_customer)->first();
			$harga = Harga::where('IDHarga',$idHarga)->first();
			
			if(empty($order))
			{
				$this->errMsg = json_encode(['order' => $order]);
				$this->emit('err-terjadi');
			}

			if(empty($harga))
			{
				$this->errMsg = json_encode(['harga' => $harga]);
				$this->emit('err-terjadi');
			}

			if(!empty($order) && !empty($harga))
			{
				$check_duplicate = OrderItem::where('IDHarga', $idHarga)->where('IDOrder',$order->IDOrder);

				if($check_duplicate->count() == 0)
				{
					$db             = new OrderItem;
					$db->IDOItem    = OrderItem::getID();
					$db->IDHarga    = $idHarga;
					$db->Jumlah     = $jumlah;
					$db->Harga      = $harga->HargaJual;
					$db->IDOrder    = $order->IDOrder;
					
					$db->save();
				}
				else
				{
					$result = $check_duplicate->first();

					OrderItem::where('IDOItem', $result->IDOItem)->update([
						'Jumlah' => ($result->Jumlah + $jumlah)
					]);
				}
				$this->emit('close-select-barang');
			}
        }
    }

    public function initItemUpdate()
    {
        $db         = OrderItem::find($this->item_update);
        $db->Jumlah = $this->jumlah;
        $db->save();

        $this->jumlah      = '';
        $this->item_update = '';

        $this->mount();
        $this->emit('close-modal-item-update');
    }

   

    public function initUpdateItem($id = '')
    {
        if($id != '')
        {
            $result = OrderItem::where('IDOItem',$id)->first();

            $this->jumlah       = $result->Jumlah;
            $this->item_update  = $result->IDOItem;

            $this->emit('show-modal-item-update');
        }
    }

    public function removeItem()
    {
        if($this->item_remove != '')
        {
            $order = OrderItem::where('IDOItem', $this->item_remove);

            if($order->count() != 0)
            {
                $order->delete();
                
                $this->item_remove = '';
            }
            
            $this->mount();
            $this->emit('close-del-item');
        }
    }

    public function sendOrder()
    {
        $update = [
            'Status' => 1,
            'IDOS'   => 2
        ];

        if($this->deadline != '')
        {
            $update['deadline'] = $this->deadline;
        }

        if($this->ongkir != 0)
        {
            $update['ongkir']   = $this->ongkir;
        }

        if($this->ekspedisi != 0)
        {
            $update['IDEkspedisi']= $this->ekspedisi;
        }

        Orders::where('IDOrder',$this->orderCancel)->update($update);

        $this->emit('close-pembayaran');
        
        $this->ekspedisi    = 0;
        $this->deadline     ='';
        $this->ongkir       = 0;
        $this->mount();
    }

    public function cancelOrder()
    {
        $item = OrderItem::where('IDOrder', $this->orderCancel);

        if($item->count() != 0)
        {
            $item->delete();
        }
        
        Orders::destroy($this->orderCancel);

        $this->ekspedisi = 0;
        $this->ongkir    = 0;

        $this->emit('close-pembatalan');
        $this->mount();
    }



    public function mount()
    {
        $res = Orders::where('IDOS',6)->first();

        if(empty($res))
        {
            $this->page_active     = 'order';
            $this->btn_active      = 'order';

            $this->table_item      = [];
            $this->selectCustomer  = '';
            $this->jumlah          = '';
    
            $this->select_customer = '';
            $this->customer_name   = '';

            $this->item_remove      = '';
            $this->item_update      = '';

            $this->orderCancel      = '';
        
            $this->total = 0;
        }
        else
        {
            $this->customer_name   = $res->getKonsumen->Nama;
            $this->select_customer = $res->IDKonsumen;
            $this->orderCancel     = $res->IDOrder;

            $this->page_active     = 'order';
            $this->btn_active      = 'barang';

            $order                 = Orders::where('IDOS',6)->first();
            $item                  = OrderItem::with('getHarga.getStok.getBarang.getJenis')->where('IDOrder',$order->IDOrder);

            if($item->count() == 0)
            {
                $this->table_item  = [];
            }
            else
            {
                $this->table_item  = $item->get();
            }   
        }
    }

    public function render()
    {
        $ex = Fiturs::first();

        return view('livewire.transaction-order',[
            'ekspedisis'   => \App\Ekspedisi::all(),
            'fiturs'       => $ex
        ]);
    }
}
