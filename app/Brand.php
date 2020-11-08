<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table        = 'barang_brand';
    protected $primaryKey   = 'IDBrand';
    protected $fillable     = ['IDBrand','Nama','ShortName','TglCreate'];

    public $timestamps = false;
}
