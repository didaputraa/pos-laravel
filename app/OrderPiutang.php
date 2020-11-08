<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderPiutang extends Model
{
    protected $table		= 'order_piutang';
    protected $primaryKey	= 'IDOPi';
	protected $keyType		= 'string';
    protected $fillable		= ['IDOPi', 'IDOrder', 'Bayar', 'TglByr'];
    public $attributes      = [
        
    ];

    public $timestamps      = false;


    public static function getIDPiutang()
    {
        return Str::random(14).rand(11,99).Str::random(14);
    }
}
