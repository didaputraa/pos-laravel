<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Harga extends Model
{
	protected $table		= 'barang_harga';
    protected $primaryKey	= 'IDHarga';
	protected $keyType		= 'string';
	protected $fillable		= ['IDHarga','IDStok','IDHrgJns','HargaJual','HargaBeli','IDBrgEvt','Status','Icon','TglCreate','TglUpdate','DataOld'];
	protected $attributes	= [
		'HargaBeli'	=> 0,
		'Status'	=> 1,
		'Icon'		=> 'upload/-.jpg',
		'TglUpdate' => NULL,
		'DataOld'	=> '-',
		'IDBrgEvt'	=> 'A',
		'HargaBeli'	=> 0,
		'HargaJual' => 0
	];

	public $timestamps = false;
	

	public function getStok()
	{
		return $this->belongsTo('App\Stok','IDStok');
	}
}