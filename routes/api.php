<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'UserController@login');
Route::post('daftar', 'UserController@daftar');
Route::get('pengguna/{username}', 'UserController@getOneUser');

Route::get('cari-barang-lelang', 'AuctionController@searchAuction');
Route::get('barang/{idToko}', 'AuctionController@getShopAuction');
Route::get('hotItem', 'AuctionController@getHotItem');
Route::get('rekomen', 'AuctionController@getRekomen');
Route::get('barangdetail/{id}', 'AuctionController@readAuction');
// ShopController
Route::get('toko/{id}', 'ShopController@readShop');


// need to authorized
Route::group(['middleware' => ['checkjwt']], function () {
    Route::get('pengguna', 'UserController@index');
	Route::post('perbarui-profil', 'UserController@updateProfile');
    Route::post('ganti-password', 'UserController@changePassword');	
    Route::post('unggah-foto-profil', 'UserController@uploadPhoto');
	Route::get('histori-transaksi-pengguna', 'TransactionController@getUserTransactionHistory');
	
	// Alamat Pengiriman
	Route::post('tambah-alamat-pengiriman', 'UserController@addAddress');
	Route::get('alamat-pengiriman', 'UserController@getUserAddress');
	Route::post('ubah-alamat-pengiriman/{id}', 'UserController@updateAddress');
	Route::post('hapus-alamat-pengiriman/{id}', 'UserController@deleteAddress');

    Route::post('daftar-toko', 'ShopController@createShop');

    Route::post('penawaran-lelang/{id}', 'AuctionController@placeBid');

    Route::group(['middleware' => ['checktoko']], function () {
        // ShopController
        Route::post('unggah-foto-toko', 'ShopController@uploadPhoto');
        Route::post('perbarui-informasi-toko', 'ShopController@updateShop');
        Route::post('hapus-toko', 'ShopController@deleteShop');

        // AuctionController
        Route::post('mulai-lelang', 'AuctionController@createAuction');
    });
});
