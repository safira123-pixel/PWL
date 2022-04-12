<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\mahasiswa;

class Kelas extends Model
{
    use HasFactory;
    protected $table='kelas';

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class);
    }
}
