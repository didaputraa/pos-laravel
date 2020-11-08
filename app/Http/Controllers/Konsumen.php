<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Konsumen as Customer;


class Konsumen extends Controller
{
	public function store(Request $r)
	{
		$username = explode(' ',$r->input('nm'));
		
		$db = new Customer;
		
		$db->IDKonsumen 	= Customer::getPrimary();
		$db->Nama 			= $r->input('nm');
		$db->Alamat			= $r->input('almt');
		$db->NoTelp			= $r->input('telp');
		$db->Email			= $r->input('email');
		
		$db->save();
		
		Customer::updateTable();
		
		return redirect('/konsumen');
	}
	
	public function showById(Request $r,$id)
	{
		$db = Customer::find($id);
		
		if(@count($db) > 0)
		{
			return response()->json($db);
		}
		else
		{
			return response([
				'msg' => 'data tidak ditemukan'
			],500);
		}
	}
	
	public function updateById(Request $r)
	{
		$db = Customer::find($r->input('id'));
		
		$db->Nama 	=  $r->input('nm');
		$db->Email 	=  $r->input('email');
		$db->NoTelp =  $r->input('telp');
		$db->Alamat =  $r->input('almt');
		$db->Gender =  $r->input('jk');
		
		$db->save();
		
		Customer::updateTable();
	}
	
	public function delete(Request $r)
	{
		Customer::find($r->input('id'))->delete();
		
		Customer::updateTable();
	}

	public function allData()
	{
		return response(['data' => Customer::all()]);
	}
	
}