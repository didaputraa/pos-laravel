<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrgMasuk extends Model
{
    protected $table		= 'barang_masuk';
    protected $primaryKey	= 'IDBrgMasuk';
	protected $keyType		= 'string';
    protected $fillable		= ['IDBrgMasuk','Jumlah','TglMasuk','IDHarga', 'Penerima'];
    protected $attributes   = [
        'Penerima' => '-'
    ];

    public $timestamps      = false;

    public function getHarga()
    {
        return $this->belongsTo('App\Harga','IDHarga');
    }
}
