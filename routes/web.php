<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group([
	'middleware' => 'auth', 
	'layout' 	 => 'layouts.apps'
],function(){

    Route::livewire('/','beranda')->name('beranda');

    Route::livewire('/konsumen','konsumen');
});

Route::middleware('auth')->group(function(){
	
	Route::put('/konsumen/update','Konsumen@updateById')->name('k.update');
	Route::post('/konsumen/insert','Konsumen@store')->name('k.simpan');
	Route::delete('/konsumen/remove','Konsumen@delete')->name('k.delete');
	
});

Route::get('/konsumen/api/all','Konsumen@allData');
Route::get('/konsumen/show/{id}','Konsumen@showById');





/*----- produk -----*/

Route::group([
    'layout'        => 'layouts.apps',
	'middleware' 	=> 'auth'
], function(){

    Route::livewire('/product','products');
    Route::livewire('/product/harga','barangharga');
    Route::livewire('/product/stok','barangstok');
    Route::livewire('/product/brand','brand')->name('produk.brand');
    Route::livewire('/product/jenis','barangjenis');
    Route::livewire('/product/kategori','barangkategori');
    Route::livewire('/product/barang-masuk','barangmasuk');
    Route::livewire('/product/request-extra','barangrequestextra');

});


Route::name('produk.')->prefix('/product')->middleware('auth')->group(function(){
    Route::get('/show/{id}','Product@showId');
    Route::post('/insert','Product@insert')->name('save');
    Route::post('/request-extra', 'Product@requestExtra')->name('extra');
    Route::put('/update','Product@update')->name('update');
    Route::put('/harga/update','Product@update_harga')->name('update-harga');
    Route::delete('/remove','Product@delete')->name('remove');
});

/* ---------- api ----------  */

Route::prefix('/product/api')->group(function(){
    Route::get('/all','Product@getAll')->name('produk.all');
    Route::get('/jenis/all','Product@getJenis_all')->name('produk.j.all');
    Route::get('/jenis/{id}','Product@getJenis');
    Route::get('/kategori/all','Product@getKategori_all')->name('produk.k.all');
    Route::get('/kategori/{id}','Product@getKategori');
    Route::get('/barang/{id}','Product@getBarang');
    Route::get('/event/all','Product@getEvent')->name('produk.evt.all');
    Route::get('/piutang','Product@piutang')->name('produk.piutang');
    Route::get('/request-extra-getjenis/{id}','Product@requestExtraJenis');
});

/*----- produk -----*/





/*----- bahan baku -----*/

Route::group([
    'layout'        => 'layouts.apps',
	'middleware' 	=> 'auth'
],function(){

    Route::livewire('bahan-baku','bahanbaku');
    Route::livewire('bahan-baku-item/{id}','bahanbakuitem')->where('id','[0-9]+');
    Route::livewire('bahan-baku-item-edit/{id}','bahanbakuitemedit');

});

Route::name('baku.')->prefix('/bahan-baku')->middleware('auth')->group(function(){
    Route::post('/insert','BahanBaku@insert')->name('add');
    Route::post('/insert-item','BahanBaku@insert_item')->name('addItem');
    Route::get('/show/{id}','BahanBaku@show');
    Route::put('/update','BahanBaku@update')->name('update');
    Route::put('/update-item','BahanBaku@update_item')->name('update-item');
    Route::delete('/remove','BahanBaku@remove')->name('remove');
    Route::delete('/remove-item','BahanBaku@remove_item')->name('remove-item');
});
/*----- bahan baku -----*/




Route::group([
    'layout'        => 'layouts.apps',
	'middleware' 	=> 'auth'
],function(){

    Route::livewire('/ekspedisi','ekspedisi');

    Route::livewire('/event','events');

});

/*----- transaction-----*/

Route::get('/pembelian/api/show','Product@pembelian');

Route::group([
    'layout'        => 'layouts.apps',
	'middleware' 	=> 'auth'
], function(){

    Route::livewire('/order','transactionorder');

    Route::livewire('/pembayaran','transactionpembayaran');

    Route::livewire('/pembelian','transactionpembelian');

    Route::livewire('/piutang','transactionpiutang');

    Route::livewire('/pengerjaan','transactionpengerjaan');

    Route::livewire('/pengiriman','transactionpengiriman');
	
	Route::livewire('/laporan-penjualan','laporanpenjualan');
    Route::livewire('/laporan-labarugi','laporanlabarugi');
    
    Route::livewire('/percetakan-nota','percetakannota');
    Route::livewire('/percetakan-resi','percetakanresi');

    Route::livewire('/fitur', 'fitur');

    Route::livewire('/account', 'account');

    Route::livewire('/setting-profile','settingprofile');

});

/*----- transaction-----*/


Route::prefix('/percetakan/api')->name('cetak.')->group(function(){

    Route::get('/nota', 'Percetakan@nota')->name('nota');
    Route::get('/resi', 'Percetakan@resi')->name('resi');

});

Route::prefix('/api')->group(function(){
	Route::get('/laporan/nota/{week}','ApiController@laporanNota');
});