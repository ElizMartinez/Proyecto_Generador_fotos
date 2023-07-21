<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fotos extends Model
{
    use HasFactory;
    protected $table = 'fotos';

    protected $primaryKey = "id_fotos";
    protected $fillable = [
        'titulo_foto',
        'descripcion_foto',
        'coleccion_id',
        'pie_foto',
        'path'
    ];
    public function coleccion()
    {
        return $this->belongsTo(coleccion::class, 'coleccion_id');
    }

}