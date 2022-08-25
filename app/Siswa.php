<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Siswa extends Authenticatable implements JWTSubject
{
	use Notifiable;
  protected $table = 'siswa';
  protected $primarykey = 'nisn';
  protected $fillable = ['nis', 'nama' , 
  'id_kelas' , 'alamat' , 'no_telp','username','password'];
  public $timestamps = true;
  public function getJWTIdentifier()
  {
  return $this->getKey();
  } 
  public function getJWTCustomClaims()
  {
   return [];
  }
}