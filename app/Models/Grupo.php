<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'codigo',
        'status',
        'user_id',
        'institucion_id',
    ];

    protected $table = 'grupos';
    public function Tipos()
    {
        return $this->hasMany(Tipo::class);
    }
}
