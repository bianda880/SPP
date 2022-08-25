<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Pembayaran;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Transaksi;

class TransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'nisn' => 'required',
            'bulan_bayar'=>'required',
            'tahun_bayar'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $ceklunas=Transaksi::where('nisn',$request->get('nisn'))
        	->where('bulan_bayar',$request->get('bulan_bayar'))
        	->where('tahun_bayar',$request->get('tahun_bayar'));
        if($ceklunas->count()>0){
        	$dt_status=$ceklunas->first();
        	if($dt_status->status_lunas=="belum lunas"){
	        	$pembayaran = Pembayaran::create([
		        	'id_petugas'=>JWTAuth::user()->id_petugas,
		        	'nisn'=>$request->get('nisn'),
		        	'tgl_bayar'=>date('Y-m-d'),
		        	'bulan_bayar'=>$request->get('bulan_bayar'),
		        	'tahun_bayar'=>$request->get('tahun_bayar'),
		        ]);
		        if($pembayaran){
		        	$update_tunggakan=Transaksi::where('nisn',$request->get('nisn'))
		        	->where('bulan_bayar',$request->get('bulan_bayar'))
		        	->where('tahun_bayar',$request->get('tahun_bayar'))
		        	->update([
		        		'status_lunas'=>'lunas'
		        	]);
		        	return response()->json(['status'=>true ,'message'=>'sukses pembayaran']);
		        } else {
		        	return response()->json(['status'=>false ,'message'=>'gagal pembayaran']);
		        }
	        } else if($dt_status->status_lunas=="lunas"){
	        	return response()->json(['message'=>'Bulan ini sudah lunas, tidak perlu membayar']);
	        } 
        }else {
	        return response()->json(['message'=>'Tidak ada tunggakan']);
	    }


	}
	public function kurang_bayar($nisn){
    	$gethistori=Transaksi::select('siswa.nisn','siswa.nama','kelas.nama_kelas','kelas.jurusan','nominal')
		->join('siswa','siswa.nisn','=','tunggakan.nisn')
    	->join('kelas','kelas.id_kelas','=','siswa.id_kelas')
    	->join('spp','spp.angkatan','=','kelas.angkatan')
    	->where('tunggakan.nisn',$nisn)
    	->where('status_lunas','belum lunas')
    	->get();
    	return response()->json($gethistori);
    }

	
}

