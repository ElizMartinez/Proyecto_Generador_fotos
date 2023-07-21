<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyectos extends Model
{
    use HasFactory;
    protected $primaryKey = "id_proyecto";
    protected $fillable = [
        'nombre_proyecto',
        'expediente',
        'descripcion'
    ];
    public function coleccion()
    {
        return $this->hasMany(coleccion::class, 'proyecto_id');
    }
}