<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'status',
        'tipo_id',
        'caracteristicas',
        'user_id',
    ];

    protected $table = 'subtipos';
}
