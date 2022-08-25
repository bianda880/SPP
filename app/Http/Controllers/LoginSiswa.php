<?php
namespace App\Http\Controllers;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Config;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginSiswa extends Controller
{
    function __construct(){
        Config::set('jwt.user', \App\Siswa::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => \App\Siswa::class,
        ]]);
    }
    public function loginsiswa(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $level  = 'siswa';
        $nama   = Auth::user()->nama;
        $nisn   = Auth::user()->nisn;
        return response()->json(compact('token','level','nama','nisn'));
    }

   
    public function registersiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'nis'=>'required|string|max:255',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:siswa',
            'alamat'=>'required|string',
            'no_telp'=>'required|string|max:255',
            'id_kelas'=>'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $siswa = Siswa::create([
        	'nis'=>$request->get('nis'),
        	'nama'=>$request->get('nama'),
        	'alamat'=>$request->get('alamat'),
        	'no_telp'=>$request->get('no_telp'),
        	'username'=>$request->get('username'),
        	'password' => Hash::make($request->get('password')),
        	'id_kelas'=>$request->get('id_kelas'),
        ]);
        $token = JWTAuth::fromUser($siswa);
        return response()->json(compact('siswa','token'),201);
    }

    public function getSiswaKelas(){
        $getsiswa = Siswa::join('kelas', 'kelas.id_kelas', 'siswa.id_kelas')->get();
        return response()->json(['data' => $getsiswa]);
    }

    // public function getAuthenticatedUser()
    // {
    //     try {
    //         if (! $user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['user_not_found'], 404);
    //         }
    //     } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    //         return response()->json(['token_expired'], $e->getStatusCode());
    //     } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    //         return response()->json(['token_invalid'], $e->getStatusCode());
    //     } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
    //         return response()->json(['token_absent'], $e->getStatusCode());
    //     }
    //     return response()->json(compact('user'));
    // }
    public function getprofile()
    {
    	return response()->json(['data'=>JWTAuth::user()]);
    }
    public function getprofileleadmin(){
        return response()->json(['data'=>JWTAuth::user()]);
    }
}