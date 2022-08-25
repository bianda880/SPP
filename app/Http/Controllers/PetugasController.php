<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Petugas;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class PetugasController extends Controller
{

    //POST
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'email'      =>'required',
            'password'      =>'required',
            'nama_petugas'  =>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = Petugas::create([
            'email'      =>$req->email,
            'password'      => Hash::make($req->get('password')),
            'nama_petugas'  =>$req->nama_petugas,
        ]);
        if ($save) {
            return Response()->json(['status'=>'Berhasil menambahkan petugas']);
        }else{
            return Response()->json(['status'=>'Gagal menambahkan petugas']);
        }
    }

    //UPDATE
    public function update(Request $request, $id_petugas)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas'  => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'password'      => 'required|string|min:6|confirmed',
            'level'         => 'required',
        ]);

        if($validator->fails()) {
            $data['status']     = false;
            $data['message']   = $validator->errors();
            return Response ()->json($data);
        }    

        //Data PETUGAS
        $petugas = Petugas::where('id_petugas', $id_petugas)->update([
            'nama_petugas'  => $request->get('nama_petugas'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('password')),
        ]);
        
        //Data USER
        $user = User::where('id_petugas', $id_petugas)->update([
            'name'          => $request->get('nama_petugas'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('password')),
            'level'         => $request->get('level'),
        ]);

        if($user){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate petugas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate petugas']);
        }
        if($petugas){
            return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate petugas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate petugas']);
        }
    }

    //DELETE
    public function destroy($id_petugas)
    {
        $hapus=Petugas::where('id_petugas',$id_petugas)->delete();
        if($hapus){
            return Response()->json(['status'=>'Berhasil menghapus petugas']);            
        }else{
            return Response()->json(['status'=>'Gagal menghapus petugas']);
        }
    }

    //GET
    public function Petugas(){
        $getpetugas=Petugas::get();
        return Response()->json(['data'=>$getpetugas]);
    }
    public function getdetailpetugas($id_petugas){
        $detail=User::where('id_petugas', $id_petugas)->first();
        return Response()->json($detail);
    }
}
