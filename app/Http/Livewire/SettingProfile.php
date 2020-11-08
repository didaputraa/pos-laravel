<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;


class Settingprofile extends Component
{
	public $profile = ['nama' => '', 'email' => '', 'level' => '', 'tgl' => ''];
	public $update  = ['nama' => '', 'email' => '', 'level' => '', 'password' => '', 'passConfirm' => '', 'act' => 0, 'msg' =>''];
	
	
	public function mount()
	{
		$o = Auth::user();
		
		$this->profile['nama'] 	= $o->name;
		$this->profile['email']	= $o->email;
		$this->profile['level']	= $o->level;
		$this->profile['tgl']	= $o->created_at;
		
		$this->update['nama'] 	= $o->name;
		$this->update['email']	= $o->email;
		$this->update['level']	= $o->level;
	}
	
	public function update_data()
	{
		$this->validate([
			'update.nama'	=> 'required|max:32|min:3',
			'update.email'	=> 'required'
		],[
			'update.nama.required'	=> 'Harap isi nama pengguna',
			'update.email.required'	=> 'Harap isi email pengguna',
			'update.nama.max'		=> 'Maksimal nama 32 huruf',
			'update.nama.min'		=> 'Minimal nama 3 huruf'
		]);
		
		$d = User::find(Auth::user()->id);
		
		$d->name	= $this->update['nama'];
		$d->email	= $this->update['email'];
		$d->level	= $this->update['level'];
		$d->save();
		
		return redirect()->to('setting-profile');
	}
	
	public function validatePassword()
	{
		/*if($this->update['password'] == $this->update['passConfirm'])
		{
			$this->update['act'] = 1;
			$this->update['msg'] = '';
		}
		else
		{
			$this->update['msg'] = 'harap cek password';
		}*/
		$this->validate([
			'update.passConfirm' => 'same:update.password'
		],[
			'update.passConfirm.same' => 'Harap cek kembali password yg anda masukkan'
		]);

		$this->update['act'] = 1;
	}
	
	public function update_password()
	{
		$u = User::find(Auth::user()->id);
		$u->password = Hash::make($this->update['password']);
		$u->save();
		
		$this->update['act'] = 0;
		$this->update['msg'] = '';
		
		$this->emit('close-setting-password');
	}
	
    public function render()
    {
		
        return view('livewire.setting-profile');
    }
}