<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class OrderItem extends Model
{
    protected $table		= 'order_item';
    protected $primaryKey	= 'IDOItem';
	protected $keyType		= 'string';
    protected $fillable		= ['IDOItem','IDOrder','IDHarga','Jumlah','Harga','Terproses','TglPengerjaan','TglTerproses','TglSelesai','EvtLog'];
    public $attributes      = [
        'EvtLog'    => '-',
    ];

    public $timestamps      = false;


    public function getHarga()
    {
        return $this->belongsTo('App\Harga','IDHarga');
    }

    public static function getID()
    {
        return Str::random(25);
    }
}