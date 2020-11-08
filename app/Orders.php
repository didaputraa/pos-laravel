<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Orders extends Model
{
    protected $table		= 'orders';
    protected $primaryKey	= 'IDOrder';
	protected $keyType		= 'string';
	protected $fillable		= ['IDOrder','NoResi','IDKonsumen','Bayar','TglPesan','Deadline','TglKirim','Capture','Ongkir','IDEkspedisi','Status','IDOMe','IDOS','NoFaktur'];
    protected $attributes	= [
        'Status'    => 0,
        'IDOS'      => 6,
        'IDOMe'     => 0
    ];

    public $timestamps      = false;

    
    public function getKonsumen()
    {
        return $this->belongsTo('App\Konsumen','IDKonsumen');
    }

    public function getItem()
    {
        return $this->hasOne('App\OrderItem','IDOrder');
    }
	
	public function getEkspedisi()
	{
		return $this->belongsTo('App\Ekspedisi','IDEkspedisi');
	}
  

    public static function getNoFaktur()
    {
        return Str::random(16);
    }

    public static function getNoResi()
    {
        return Str::random(5).'-'.Str::random(5).'-'.Str::random(5).'-'.Str::random(7);
    }

    public static function getIDOrder()
    {
        return Str::random(24);
    }
}
