<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Orders;

class Percetakan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nota()
    {
        $res = Orders::with('getKonsumen')->get();
        
        return response()->json([
            'data' => $res
        ]);
    }
}
