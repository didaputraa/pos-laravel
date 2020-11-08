<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		
    }
	public function laporanNota($week = 0)
	{
		$res 	= [];
		$inc 	= [];
		$start  = floor($week * 7);
		$end    = floor(($week + 1) * 7);
		
		$tbl = Orders::select('TglPesan')->where('IDOS',4)
				->whereMonth('TglPesan', today())
				->whereRaw("DAYOFMONTH(TglPesan) >= {$start} && DAYOFMONTH(TglPesan) <= {$end}")->get();
		
		if(!empty($tbl))
		{
			$col = collect($tbl)->mapToGroups(function($item){

				switch(date('N',strtotime($item['TglPesan'])))
				{
					case 1: $day = 'Senin'; break;

					case 2: $day = 'Selasa'; break;

					case 3: $day = 'Rabu'; break;

					case 4: $day = 'Kamis'; break;

					case 5: $day = 'Jumat'; break;

					case 6: $day = 'Sabtu'; break;

					case 7: $day = 'Minggu'; break;
				}

				return ['Tgl' => $day];
			})->all();
			
			if(!empty($col['Tgl']))
			{
				$res = collect($col['Tgl'])->unique();
				$inc = [];

				foreach($res as $h)
				{
					switch($h)
					{
						case 'Senin'    : $inc[0] = $h; break;
						case 'Selasa'   : $inc[1] = $h; break;
						case 'Rabu'     : $inc[2] = $h; break;
						case 'Kamis'    : $inc[3] = $h; break;
						case 'Jumat'    : $inc[4] = $h; break;
						case 'Sabtu'    : $inc[5] = $h; break;
						case 'Minggu'   : $inc[6] = $h; break;
					}
				}
			}
			
			$hari = collect($inc)->sortKeys()->values()->all();
			
			return response()->json(['tbl' => $tbl, 'hari' => $hari]);
		}
		else
		{
			return response('err',500);
		}
	}
}
