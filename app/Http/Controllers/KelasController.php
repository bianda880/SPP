<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Validator;

class Kelascontroller extends Controller
{

    //POST
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'nama_kelas'=>'required',
            'jurusan'   =>'required',
            'angkatan'  =>'required',
        ]);
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return Response()->json($data);
        }
        $save = Kelas::create([
            'nama_kelas'    =>$req->nama_kelas,
            'jurusan'       =>$req->jurusan,
            'angkatan'      =>$req->angkatan,
        ]);
        if($save){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menambahkan kelas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menambahkan kelas']);
        }
    }

    //UPDATE
    public function update(Request $req, $id_kelas)
    {
        $validator = Validator::make($req->all(),[
            'nama_kelas'=>'required',
            'jurusan'   =>'required',
            'angkatan'  =>'required',
        ]);
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return Response()->json($data);
        }
        $ubah=Kelas::where('id_kelas',$id_kelas)->update([
            'nama_kelas'    =>$req->nama_kelas,
            'jurusan'       =>$req->jurusan,
            'angkatan'      =>$req->angkatan,
        ]);
        if($ubah){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate kelas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate kelas']);
        }
    }

    //DELETE
    public function destroy($id_kelas)
    {
        $hapus=Kelas::where('id_kelas',$id_kelas)->delete();
        if($hapus){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menghapus data']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menghapus data']);
        }
    }

    //GET
    public function Kelas(){
        $getkelas=Kelas::get();
        return Response()->json($getkelas);
    }
    public function getdetailkelas($id_kelas){
        $detail=Kelas::where('id_kelas',$id_kelas)->first();
        return Response()->json($detail);
    }
}
