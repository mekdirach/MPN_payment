<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tg_biller_mpn_tran_main extends Model
{
    use Notifiable;
    protected $table = "tg_biller_mpn_tran_main";
    protected $fillable = [
        'tgb_tm_nama_wajib_pajak', 'tgb_tm_nama_wajib_bayar'
    ];
}
