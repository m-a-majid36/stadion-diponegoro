<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ruko()
    {
        return $this->belongsTo(Ruko::class, 'id_ruko');
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa');
    }
}
