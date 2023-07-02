<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'direccion',
        'contacto',
        'responsable',
        'codigo_id',
        'email',
        'telefono',
        'image',
        'status',
        'user_id',
        'localidad_id',
        'detalle_codificacion',
        'ejemplo_codificacion'
    ];

    protected $table = 'institucion';

    public function getImagenAttribute()
    {
        if (file_exists('storage/instituciones/' . $this->image)) {
            return $this->image;
        } else {
            return 'default.png';
        }
    }
}
