<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'ci',
        'cargo',
        'status',
        'user_id',
    ];

    protected $table = 'responsables';

    public function Areas()
    {
        return $this->hasMany(Area::class);
    }
}
