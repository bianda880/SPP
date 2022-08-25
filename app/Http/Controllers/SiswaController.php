<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{

    //POST
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'username'  =>'required',
            'password'  =>'required',
            'nis'       =>'required',
            'nama'      =>'required',
            'id_kelas'  =>'required',
            'alamat'    =>'required',
            'no_telp'   =>'required',
        ]);
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return Response()->json($data);
        }
        $save = Siswa::create([
            'username'      =>$req->username,
            'password' => Hash::make($req->get('password')),
            'nis'           =>$req->nis,
            'nama'          =>$req->nama,
            'id_kelas'      =>$req->id_kelas,
            'alamat'        =>$req->alamat,
            'no_telp'       =>$req->no_telp,
        ]);
        if($save){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menambahkan siswa']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menambahkan siswa']);
        }
    }

    //UPDATE
    public function update(Request $req, $nisn)
    {
        $validator = Validator::make($req->all(),[
            'username'  =>'required',
            'nis'       =>'required',
            'nama'      =>'required',
            'id_kelas'  =>'required',
            'alamat'    =>'required',
            'no_telp'   =>'required',
        ]);
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return Response()->json($data);
        }
        $ubah=Siswa::where('nisn',$nisn)->update([
            'username'      =>$req->username,
            'nis'           =>$req->nis,
            'nama'          =>$req->nama,
            'id_kelas'      =>$req->id_kelas,
            'alamat'        =>$req->alamat,
            'no_telp'       =>$req->no_telp,
        ]);
        if($ubah){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate siswa']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate siswa']);
        }
    }

    //DELETE
    public function destroy($nisn)
    {
        $hapus=Siswa::where('nisn',$nisn)->delete();
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
    public function Siswa(){
        $getsiswa=Siswa::get();
        return Response()->json($getsiswa);
    }
    public function getdetailsiswa($nisn){
        $detail=Siswa::where('nisn',$nisn)->first();
        return Response()->json($detail);
    }
}
