<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'observation',
        'status',
        'bloque_id',
        'responsable_id',
        'user_id',
    ];

    protected $table = 'areas';

    public function Responsables()
    {
        return $this->belongsTo(Responsable::class);
    }
}
