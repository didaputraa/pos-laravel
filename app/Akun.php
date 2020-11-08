<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table 		= 'akun';
	protected $primaryKey	= 'IDAkun';
	protected $keyType		= 'string';
	protected $fillable		= ['IDAkun', 'Nama', 'Username', 'Password','Email', 'TglCreate','TglUpdate', 'lastLogin', 'IDLvAkses', 'Status'];
	
	const CREATED_AT 		= 'TglCreate';
	const UPDATED_AT		= 'TglUpdate';
}
