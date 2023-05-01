<?php

namespace App\Models;

use App\Models\Penyewa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruko extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
