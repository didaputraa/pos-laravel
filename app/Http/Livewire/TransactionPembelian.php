<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Pembelian;
use App\Resep;

class Transactionpembelian extends Component
{
    public $pageActiveNow , $itemBarang, $barang;

    public $errBrg = 0,
           $idDel, $idEye;

    public $tblItem         = [], $tblBrg = [], $tblEye = [],
           $tgl             = '',
           $select2         = '',
           $biayaLain       = 0;


    public function backViewFront()
    {
        $this->pageActiveNow = 'view';
    }

    public function showInitPembelian()
    {
        $this->tblItem      = Resep::all();
        $this->tblBrg       = [];
        $this->tgl          = date('Y-m-d',strtotime('now'));

        $this->pageActiveNow = 'pembelian';
    }

    public function viewItem_pembelian($idItem)
    {
        if($idItem != '')
        {
            $this->tblEye = Pembelian::where('IDP', $idItem)->first();
        }
    }

    public function emptyEye()
    {
        $this->tblEye = [];
    }

    public function send()
    {
        $ex         = explode(',', $this->select2);
        $resepItem  = [];
        $i = 0;
        $l = [];

        foreach($ex as $k => $row)
        {
            if($row != '')
            {
                $resep = DB::table('barang_pembelian_resep')->select(
                    'IDBPR', 
                    'Label',
                    'Biaya',
                    'BiayaLain',
                    DB::raw("(Biaya + BiayaLain) AS biaya")
                )->where('IDBPR', $row)->groupBy('IDBPR','Label','Biaya','BiayaLain');

                if($resep->count() != 0)
                {
                    $result = $resep->first();

                    $l[] = [
                        'id'    => $result->IDBPR,
                        'label' => $result->Label,
                        'biaya' => ($result->Biaya + $result->BiayaLain)
                    ];

                    $i += $result->biaya;
                }
                else
                {
                    $l = ['-'];
                }
            }

            $resepItem['item']  = json_encode($l);
            $resepItem['biaya'] = $i;
        }

        $data[] = [
            'IDP'           => Pembelian::getID(),
            'Tgl'           => $this->tgl.' '.date('H:i:s',strtotime('now')),
            'Biaya'         => $resepItem['biaya'],
            'BiayaLain'     => $this->biayaLain,
            'RincianItem'   => $resepItem['item']
        ];
        
        Pembelian::insert($data);

        $this->pageActiveNow = 'view';
    }

    public function deleteItem()
    {
        if($this->idDel != '')
        {
            Pembelian::destroy($this->idDel);

            $this->idDel = '';

            $this->emit('close-del');
        }
    }


    public function mount()
    {
        $this->pageActiveNow = 'view';
    }

    public function render()
    {
        return view('livewire.transaction-pembelian');
    }
}
