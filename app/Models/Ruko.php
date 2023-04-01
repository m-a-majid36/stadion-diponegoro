<?php

namespace App\Models;

use App\Models\Penyewa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruko extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewas()
    {
        return $this->hasMany(Penyewa::class, 'id_ruko');
    }
}
