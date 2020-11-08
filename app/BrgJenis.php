<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrgJenis extends Model
{
    protected $table		= 'barang_jenis';
    protected $primaryKey	= 'IDBrgJenis';
	protected $keyType		= 'string';
    protected $fillable		= ['IDBrgjenis','IDBrgKategori','Nama'];


    public $timestamps      = false;

    
    public function getKategori()
    {
        return $this->belongsTo('App\BrgKategori','IDBrgKategori');
    }
}