<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangExtra extends Model
{
    protected $table        = 'barang_request';
    protected $primaryKey   = 'IDR';
    protected $keyType      = 'string';
    protected $fillable     = ['IDR' ,'Ket' ,'IDHarga', 'Tgl', 'Jenis'];

    protected $attributes   = ['Jenis' => 0];

    public $timestamps      = false;


    public static function getID()
    {
        return Str::random(20);
    }

    public function getHarga()
    {
        return $this->belongsTo('App\Harga', 'IDHarga');
    }
}
