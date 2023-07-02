<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'observation',
        'status',
        'localidad_id',
        'institucion_id',
        'user_id',
    ];

    protected $table = 'bloques';

    public function Localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
}
