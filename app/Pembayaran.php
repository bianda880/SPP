<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primarykey = 'id_pembayaran';
    public $timestamps = false;
    protected $fillable = [
        'id_petugas','nisn','tgl_bayar','bulan_bayar','tahun_bayar','status'
    ];
}
