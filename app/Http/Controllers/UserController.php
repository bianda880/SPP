<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Petugas;
use DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $level  = Auth::user()->level;
        $nama   = Auth::user()->name;
        return response()->json(compact('token','level','nama'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas'  => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'level'         => 'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $petugas = Petugas::create([
            'email'=>$request->get('email'),
            'password' => Hash::make($request->get('password')),
            'nama_petugas' => $request->get('nama_petugas'),            
        ]);
        $user = User::create([
            'name' => $petugas->nama_petugas,
            'email' => $petugas->email,
            'password' => $petugas->password,
            'level' => $request->get('level'),
            'id_petugas'=>DB::getPdo()->lastInsertId(),
        ]);
        if($petugas){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menambahkan petugas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menambahkan petugas']);
        }
        if($user){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menambahkan petugas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menambahkan petugas']);
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

     //UPDATE
    //  public function update(Request $req, $id)
    //  {
    //      $validator = Validator::make($req->all(),[
    //          'nama_petugas' =>'required',
    //          'email'        =>'required',
    //          'level'        =>'required',
    //      ]);
    //      if($validator->fails()){
    //          return Response()->json($validator->errors());
    //      }
    //      $petugas = Petugas::where('id_petugas',$id)->update([
    //         'email'         =>$req->get('email'),
    //         'nama_petugas'  => $req->get('nama_petugas'),            
    //     ]);
    //      $ubah = User::where('id',$id)->update([
    //          'name'         =>$req->get('nama_petugas'),
    //          'email'        =>$req->get('email'),
    //          'level'        =>$req->get('level'),
    //      ]);
    //      if($ubah){
    //          return Response()->json(['status'=>true ,'message'=>'Berhasil mengupdate petugas']);            
    //      }else{
    //          return Response()->json(['status'=>false ,'message'=>'Gagal mengupdate petugas']);
    //      }
    //  }

     //DELETE
    public function destroy($id)
    {
        $hapus=User::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>true ,'message'=>'Berhasil menghapus petugas']);            
        }else{
            return Response()->json(['status'=>false ,'message'=>'Gagal menghapus petugas']);
        }
    }

    //GET
    public function User(){
        $getuser=User::get();
        return Response()->json($getuser);
    }
    public function getdetailuser($id){
        $detail=User::where('id',$id)->first();
        return Response()->json($detail);
    }
}
