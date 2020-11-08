<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table		= 'barang_pembelian_resep';
    protected $primaryKey	= 'IDBPR';
    protected $fillable		= ['IDBPR', 'Label', 'RincianItem', 'Biaya', 'BiayaLain', 'TglCreate'];
    protected $attributes   = array(
        'RincianItem'   => '-'
    );
    
    public $timestamps      = false;
}