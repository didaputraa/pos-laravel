<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Konsumen extends Model
{
	protected $table		= 'konsumen';
    protected $primaryKey	= 'IDKonsumen';
	protected $keyType		= 'string';
	protected $fillable		= ['IDKonsumen','Nama','Username', 'Password','Gender','NoTelp','Email','Alamat','Photo','TglCreate'];
	protected $attributes	= [
		'Photo' 	=> '-',
		'Username'	=> '-',
		'Password'	=> '-',
	];
	
	public $timestamps	= false;
	
	
	private static function char()
	{
		$char = 'abcdefghijklmnopqrstuvwxyz';
		
		return substr(str_shuffle($char),3,4);
	}
	
	private static function getRandom()
	{
		$int  = collect([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		
		$char = collect([
			self::char().$int->random(),
			self::char().$int->random(),
			self::char().$int->random(),
		]);
		
		return str_shuffle($char->random());
	}
	
	public static function getPrimary()
	{
		return 'K-'.self::getRandom().'-'.self::getRandom().'-'.self::getRandom();
	}
	
	public static function updateTable()
	{
		Cache::forever('table_konsumen', Konsumen::all());
	}
	
	public static function getAll()
	{
		if(!Cache::has('table_konsumen'))
		{
			self::updateTable();
		}
		
		return Cache::get('table_konsumen');
	}
}