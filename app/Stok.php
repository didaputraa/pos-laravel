<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table        = 'barang_stok';
    protected $primaryKey   = 'IDStok';
    protected $fillable     = ['IDStok','StokKey','StokVal','IDBrg','TglUpdate'];
    protected $keyType      = 'string';
    protected $attributes   = ['TglUpdate' => NULL];

    public $timestamps	    = false;


    public function getBarang()
    {
        return $this->belongsTo('App\Barang','IDBrg');
    }

    public function getHarga()
    {
        return $this->hasOne('App\Harga','IDStok');
    }
}