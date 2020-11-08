<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{

	public static function getID_barang()
	{
		return 'B'.Str::random(3).'-'.Str::random(3).'-'.Str::random(3);
	}

	public static function getID_barangMasuk()
	{
		return Str::random(25);
	}

	public static function getID_harga()
	{
		return 'H'.Str::random(3).rand(0,9).'-'.Str::random(2).'-'.Str::random(3).rand(0,9).Str::random(3);
	}

	public static function getID_stok()
	{
		return 'S'.Str::random(2).'-'.Str::random(2).'-'.Str::random(3).rand(0,9).Str::random(3).'-'.Str::random(2);
	}

	public static function getID_jenis()
	{
		$id = Str::random(4).'-'.Str::random(4).rand(0,9);

		return 'S'.$id.'-'.Str::random(3);
	}

	public static function getID_kategori()
	{
		$id = Str::random(3).'-'.Str::random(4).'-'.Str::random(2);

		return 'K'.$id.'-'.rand(0,9);
	}

	public static function getID_event()
	{
		return 'E'.Str::random(8).'-'.rand(0,9).'-'.Str::random(5);
	}
}