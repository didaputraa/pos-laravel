<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fiturs extends Model
{
    protected $table        = 'fitur';
    protected $fillable     = ['ekspedisi', 'ongkir', 'barangEvt','Nama', 'Email', 'Deadline', 'Alamat', 'NoTelp'];

    public $timestamps      = false;
}
