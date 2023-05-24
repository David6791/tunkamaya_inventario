<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'codigo',
        'status',
        'grupo_id',
        'caracteristicas',
        'user_id',
    ];

    protected $table = 'tipos';

    public function Grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
