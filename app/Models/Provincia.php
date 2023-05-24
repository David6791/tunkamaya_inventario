<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'observation',
        'status',
        'departamento_id',
        'user_id',
    ];

    public function Departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
    public function Municipio()
    {
        return $this->hasMany(Municipio::class);
    }
}
