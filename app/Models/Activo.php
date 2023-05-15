<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'uniq_id',
        'description',
        'costo',
        'user_id',
        'fecha_registro',
        'status',
    ];
}
