<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Kelas extends Model{
    protected $table = 'kelas';
    protected $primarykey = 'id_kelas';
    public $timestamps = false;
    protected $fillable = [
        'nama_kelas','jurusan','angkatan'
    ];
}