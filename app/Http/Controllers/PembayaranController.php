<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use Illuminate\Support\Facades\validator;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranController extends Controller
{

   //POST
   public function store (Request $req) {
    $validator = Validator::make($req->all(), [
        'nisn'              => 'required',
        'bulan_bayar'         => 'required',
        'tahun_bayar'         => 'required',
    ]);

    if($validator->fails()) {
        $data['status']     = false;
        $data['message']   = $validator->errors();
        return Response ()->json($data);
    }

    $ceklunas =  Pembayaran::where('nisn', $req->get('nisn'))
                            ->where('bulan_bayar', $req->get('bulan_bayar'))
                            ->where('tahun_bayar', $req->get('tahun_bayar'));
    
    if($ceklunas->count() == 0) {
        $pembayaran = Pembayaran::create([
            'id_petugas'    => JWTAuth::user()->id_petugas,
            'nisn'          => $req->get('nisn'),
            'tgl_bayar'     => date('Y-m-d'),
            'bulan_bayar'     => $req->get('bulan_bayar'),
            'tahun_bayar'     => $req->get('tahun_bayar'),
            'status'        => 'lunas'
        ]);

        if($pembayaran) {
            $data['status']     = true;
            $data['message']    = "Pembayaran berhasil";
        } else {
            $data['status']     = false;
            $data['message']    = "Pembayaran gagal";
        }
        return $data;
    } else {
        $data['status']     = false;
        $data['message']    = "SPP bulan ini sudah lunas";
    }
    return $data;
}

    //UPDATE
    public function update(Request $req, $id_pembayaran)
    {
        $validator = Validator::make($req->all(),[
            'id_petugas'    =>'required',
            'nisn'          =>'required',
            'tgl_bayar'     =>'required',
            'bulan_bayar'   =>'required',
            'tahun_bayar'   =>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator-errors());
        }
        $ubah=Pembayaran::where('id_pembayaran',$id_pembayaran)->update([
            'id_petugas'    =>$req->id_petugas,
            'nisn'          =>$req->nisn,
            'tgl_bayar'     =>$req->tgl_bayar,
            'bulan_bayar'   =>$req->bulan_bayar,
            'tahun_bayar'   =>$req->tahun_bayar,
        ]);
        if($ubah){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate pembayaran']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate pembayaran']);
        }
    }

    //DELETE
    public function destroy($id_pembayaran)
    {
        $hapus=Pembayaran::where('id_pembayaran',$id_pembayaran)->delete();
        if($hapus){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menghapus data']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menghapus data']);
        }
    }

    //GET
    public function Pembayaran(){
        $getpembayaran=Pembayaran::get();
        return Response()->json($getpembayaran);
    }

    public function history(){
        $histori=Pembayaran::select('pembayaran.id_pembayaran','petugas.nama_petugas','siswa.nama','tgl_bayar','bulan_bayar','tahun_bayar')
        ->join('siswa','siswa.nisn','=','pembayaran.nisn')
        ->join('petugas','petugas.id_petugas','=','pembayaran.id')
        ->get();
    	return response()->json($histori);
    }

    //get siswa
	public function getnisn($nisn) {
		$getnisn = Pembayaran::where('nisn', $nisn)->get();
		return Response()->json($getnisn);
	}

	//SEARCH
    public function cari_data($kata_kunci) {
        $detail = Pembayaran::where('nisn', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }
    
}
