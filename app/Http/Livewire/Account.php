<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\User;

class Account extends Component
{
    public $addAkun     = ['nama' => '', 'email' => '', 'password' => '', 'level' => 'operator'],
           $editAkun    = ['nama' => '', 'email' => '', 'password' => '', 'level' => 'operator'];

    public $idItem      = '';


    public function simpan()
    {
        $this->validate(
		[
            'addAkun.nama'      => 'required|min:3|max:32',
            'addAkun.email'     => 'required',
            'addAkun.password'  => 'required|min:8|max:12',
            'addAkun.level'     => 'required'
        ],
		[
            'addAkun.nama.required'      => 'harap masukkan nama',
            'addAkun.email.required'     => 'harap masukkan email',
            'addAkun.password.required'  => 'harap masukkan password pengguna',

            'addAkun.nama.min'           => 'minimal 3 karakter',
            'addAkun.password.min'       => 'minimal password 3 karakter',

            'addAkun.nama.max'           => 'maksimal 32 karakter',
            'addAkun.password.max'       => 'maksimal password 12 karakter'
        ]);

        $db = new User;

        $db->name     = $this->addAkun['nama'];
        $db->email    = $this->addAkun['email'];
        $db->password = Hash::make($this->addAkun['password']);
        $db->level    = $this->addAkun['level'];

        $db->save();

        $this->addAkun = ['nama' => '', 'email' => '', 'password' => '', 'level' => 'operator'];
        $this->emit('close-add');
    }

    public function resetValidations()
    {
        
    }

    public function initEdit($idItem)
    {
        $db = User::find($idItem);

        $this->editAkun['nama']     = $db->name;
        $this->editAkun['email']    = $db->email;
        $this->editAkun['level']    = $db->level;
        $this->idItem               = $idItem;

        $this->emit('show-edit');
    }

    public function update()
    {
        $valid = [
            'editAkun.nama'      => 'required|min:3|max:32',
            'editAkun.email'     => 'required',
            'editAkun.level'     => 'required'
        ];

        if($this->editAkun['password'] != '')
        {
            $valid['editAkun.password'] = 'min:8|max:12';
        }

        $this->validate($valid,[
            'editAkun.nama.required' => 'harap masukkan nama',
            'editAkun.email.required'=> 'harap masukkan email',

            'editAkun.nama.max'      => 'maksimal 32 karakter',
            'editAkun.nama.min'      => 'minimal 3 karakter',

            'editAkun.password.min'  => 'minimal password 8 karakter',
            'editAkun.password.max'  => 'maksimal password 12 karakter'
        ]);

        $db = User::find($this->idItem);

        $db->name     = $this->editAkun['nama'];
        $db->email    = $this->editAkun['email'];

        if($this->editAkun['password'] != '')
        {
            $db->password = Hash::make($this->editAkun['password']);
        }

        $db->level    = $this->editAkun['level'];
        $db->save();

        $this->editAkun = ['nama' => '', 'email' => '', 'password' => '', 'level' => 'operator'];
        $this->idItem   = '';

        $this->emit('close-edit');
    }

    public function initDel($idItem)
    {
        $id = User::find($idItem);

        $this->idItem = $id->id;

        $this->emit('show-konfirmasi');
    }

    public function del()
    {
        User::find($this->idItem)->delete();

        $this->idItem = '';
        $this->emit('close-konfirmasi');
    }

    public function render()
    {
        $res = User::all();

        return view('livewire.account',[
            'tbl' => $res
        ]);
    }
}
