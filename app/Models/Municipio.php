<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'observation',
        'status',
        'provincia_id',
        'user_id',
    ];

    protected $table = 'municipios';

    public function Provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function Localidad()
    {
        return $this->hasMany(Localidad::class);
    }
}
