<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventList extends Model
{
    protected $table        = 'barang_event';
    protected $primaryKey   = 'IDBrgEvt';
    protected $keyType      = 'string';
    protected $fillable     = ['IDBrgEvt','Nama','TglMulai','TglSelesai','Status'];
    protected $attributes = [
        'TglMulai'      => NULL,
        'TglSelesai'    => NULL,
        'Status'        => 1
    ];

    public $timestamps = false;
    
}
