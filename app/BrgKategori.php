<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrgKategori extends Model
{
    protected $table		= 'barang_kategori';
    protected $primaryKey	= 'IDBrgKategori';
	protected $keyType		= 'string';
    protected $fillable		= ['IDBrgKategori','Nama','IDBrand'];

    public $timestamps      = false;


    public function getBrand()
    {
        return $this->belongsTo('App\Brand','IDBrand');
    }
}
