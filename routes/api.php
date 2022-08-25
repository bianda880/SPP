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

//LOGIN/REGISTER
Route::post('login', 'UserController@login');
Route::post('register_siswa', 'LoginSiswa@registersiswa');
Route::post('login_siswa', 'LoginSiswa@loginsiswa');


Route::get('book', 'BookController@book');
Route::get('bookall', 'BookController@bookAuth')->middleware('jwt.verify');
Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');
Route::get('siswa', 'LoginSiswa@getAuthenticatedSiswa')->middleware('jwt.verify');

Route::group(['middleware'=>['jwt.verify:admin']], function() {
    //USER
    Route::get('users', 'UserController@user');
    Route::post('register', 'UserController@register');
    Route::put("/update_user/{id}", "UserController@update");
    Route::delete("/delete_user/{id}", "UserController@destroy");
    Route::get('/getdetailuser/{id}','UserController@getdetailuser');
    
    
    //KELAS
    Route::get('kelas', 'KelasController@kelas');
    Route::post("/insert_kelas", "KelasController@store");
    Route::put("/update_kelas/{id_kelas}", "KelasController@update");
    Route::delete("/delete_kelas/{id_kelas}", "KelasController@destroy");
    Route::get('/getdetailkelas/{id_kelas}','KelasController@getdetailkelas');
    // Route::get('/getdatakelas/{id}', 'KelasController@getdatakelas');
    
    //SISWA
    Route::get('siswa', 'SiswaController@siswa');
    Route::post("/insert_siswa", "SiswaController@store");
    Route::put("/update_siswa/{nisn}", "SiswaController@update");
    Route::delete("/delete_siswa/{nisn}", "SiswaController@destroy");
    Route::get('/getdetailsiswa/{nisn}','SiswaController@getdetailsiswa');
    
    //SPP
    Route::get('spp', 'SppController@spp');
    Route::post("/insert_spp", "SppController@store");
    Route::put("/update_spp/{id_spp}", "SppController@update");
    Route::delete("/delete_spp/{id_spp}", "SppController@destroy");
    Route::get('/getdetailspp/{id_spp}','SppController@getdetailspp');
    
    //PETUGAS
    Route::post('register', 'UserController@register');
    Route::get('petugas', 'PetugasController@petugas');
    Route::post("/insert_petugas", "PetugasController@store");
    Route::put("/update_petugas/{id_petugas}", "PetugasController@update");
    Route::delete("/delete_petugas/{id_petugas}", "PetugasController@destroy");
    Route::get('/getdetailpetugas/{id}','PetugasController@getdetailpetugas');
    
    //PEMBAYARAN
    Route::get('pembayaran', 'PembayaranController@pembayaran');
    Route::post("/insert_pembayaran", "PembayaranController@store");
    Route::put("/update_pembayaran/{id_pembayaran}", "PembayaranController@update");
    Route::delete("/delete_pembayaran/{id_pembayaran}", "PembayaranController@destroy");
    Route::get('/pembayarana/{id}', 'PembayaranController@cari_data');
    
    // Transaksi
    Route::post('/bayar', 'TransaksiController@transaksi');
    Route::get('/kurang_bayar', 'TransaksiController@kurang_bayar');
});

Route::group(['middleware'=>['jwt.verify:petugas']], function() {
    Route::get('siswa', 'SiswaController@siswa');
    Route::get('users', 'UserController@user');
    Route::get('pembayarans', 'PembayaranController@pembayaran');
    Route::get('/pembayaranas/{id}', 'PembayaranController@cari_data');
    Route::post("/insert_pembayarans", "PembayaranController@store");
    Route::post('/bayarr', 'TransaksiController@transaksi');
    Route::get('/kurang_bayarr', 'TransaksiController@kurang_bayar');
});

Route::group(['middleware'=>['jwt.verifysiswa']], function() {
    Route::get('siswa', 'SiswaController@siswa');
    Route::get('users', 'UserController@user');
    Route::get('/kurang_bayarrr', 'TransaksiController@kurang_bayar');
    Route::get('/pembayaranss/{nisn}', 'PembayaranController@getnisn');
});