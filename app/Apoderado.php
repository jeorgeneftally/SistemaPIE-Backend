<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    protected $table='apoderados';
    
    protected $fillable = [
        'nombre','apellido','telefono','email','parentesco','actividad','direccion','nivel_educacional','estado'
    ];
    //relacion uno a muchos de user-diagnostico
    public function estudiante_apoderado(){
        return $this->hasMany('App\EstudianteApoderado');
    }
}
