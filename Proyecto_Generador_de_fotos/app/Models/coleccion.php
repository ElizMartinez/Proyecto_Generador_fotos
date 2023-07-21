<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coleccion extends Model
{
    use HasFactory;
  protected $table = 'coleccion';

    protected $primaryKey = "id_coleccion";
    protected $fillable = [
        'nombre_coleccion',
        'proyecto_id',
    ];
    public function proyecto()
    {
        return $this->belongsTo(proyectos::class, 'proyecto_id');
    }
    
    public function fotos(){
        return $this->hasMany(fotos::class, 'coleccion_id');
    }
}