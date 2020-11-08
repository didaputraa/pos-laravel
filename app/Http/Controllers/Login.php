<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;

/*
class Login extends Controller
{
	public function login(Request $input)
	{
		return view('dashboard/login');
	}
	
    public function login_proses(Request $input)
	{
		if($input->isMethod('post'))
		{
			$user = $input->input('username');
			$pass = md5($input->input('password'));
			
			
			// pengenalan identitas pengguna
			$db = Akun::select('Username','Password')
					->where('Username', $user)
					->where('Password', $pass)
					->get();
			
			
			if(count($db) > 0)
			{
				session(['user' => $db[0]->Username]);
				session(['logIn' => 11]);
				
				return redirect('/');
			}
			else
			{
				return redirect('/login')->withInput($input->except('password'));
			}
		}
		
		return redirect('/login');
	}
}
*/