<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Barang extends Model
{
    protected $table		= 'barang';
    protected $primaryKey	= 'IDBrg';
	protected $keyType		= 'string';
    protected $fillable		= ['IDBrg','KodeBrg','Nama','ShortName','IDBrgJenis'];

    public $timestamps      = false;


    public function getJenis()
    {
        return $this->belongsTo('App\BrgJenis','IDBrgJenis');
    }

    public function getKategori()
    {
        return $this->hasManyThrough('App\BrgKategori','App\BrgJenis','IDBrgJenis','IDBrgKategori','IDBrgJenis','IDBrgKategori');
    }

    public function getStok()
    {
        return $this->hasOne('App\Stok','IDBrg');
    }
}