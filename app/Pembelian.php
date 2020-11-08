<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembelian extends Model
{
    protected $table		= 'barang_pembelian';
    protected $primaryKey	= 'IDP';
    protected $fillable		= ['IDP', 'Tgl', 'Biaya', 'BiayaLain', 'RincianItem'];
    

    public $timestamps      = false;


    public static function getID()
    {
        return Str::random(32);
    }
}
