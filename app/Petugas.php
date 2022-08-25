<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primarykey = 'id_petugas';
    public $timestamps = false;
    protected $fillable = [
        'email', 'password','nama_petugas' 
    ];
}
