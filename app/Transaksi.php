<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table='tunggakan';
    protected $primaryKey='id_transaksi';
    public $timestamps = false;
    protected $fillabl= [
        'nisn','bulan_bayar','tahun_bayar','status_lunas'
    ];
}
