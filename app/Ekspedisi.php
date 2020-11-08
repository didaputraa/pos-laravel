<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ekspedisi extends Model
{
    protected $table           = 'ekspedisi';
    protected $primaryKey      = 'IDEkspedisi';
    protected $keyType         = 'string';
    protected $fillable        = ['IDEkspedisi','Nama'];

    public $timestamps         = false;

    
    public static function getID()
    {
        return Str::random(5);
    }
}
