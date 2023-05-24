<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'observation',
        'status',
        'municipio_id',
        'user_id',
    ];

    protected $table = 'localidades';

    public function Municipio()
    {
        return $this->belongsTo(Municipio::class);
    }
    public function Bloque()
    {
        return $this->hasMany(Bloque::class);
    }
}
