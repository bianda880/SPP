<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spp;
use Illuminate\Support\Facades\Validator;

class SppController extends Controller
{

    //POST
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'angkatan'     =>'required',
            'tahun'     =>'required',
            'nominal'   =>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = Spp::create([
            'angkatan'     =>$req->angkatan,
            'tahun'     =>$req->tahun,
            'nominal'   =>$req->nominal,
        ]);
        if($save){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menambahkan spp']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menambahkan spp']);
        }
    }

    //UPDATE
    public function update(Request $req, $id_spp)
    {
        $validator = Validator::make($req->all(),[
            'angkatan'=>'required',
            'tahun'=>'required',
            'nominal'   =>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator-errors());
        }
        $ubah=Spp::where('id_spp',$id_spp)->update([
            'angkatan'    =>$req->angkatan,
            'tahun'    =>$req->tahun,
            'nominal'       =>$req->nominal,
        ]);
        if($ubah){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate spp']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate spp']);
        }
    }

    //DELETE
    public function destroy($id_spp)
    {
        $hapus=Spp::where('id_spp',$id_spp)->delete();
        if($hapus){
            $data['status']=true;
            $data['message']="Sukses menghapus data";
        }else{
            $data['status']=false;
            $data['message']="Gagal menghapus data";
        }
        return Response()->json($data);
    }

    //GET
    public function Spp(){
        $getspp=Spp::get();
        return Response()->json($getspp);
    }
    public function getdetailspp($id_spp){
        $detail=Spp::where('id_spp',$id_spp)->first();
        return Response()->json($detail);
    }
}
