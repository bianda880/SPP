<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spp';
    protected $primarykey = 'id_spp';
    public $timestamps = false;
    protected $fillable = [
        'angkatan','tahun','nominal'
    ];
}
