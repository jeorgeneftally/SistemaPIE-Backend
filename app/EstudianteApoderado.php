<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudianteApoderado extends Model
{
    protected $table='estudiantes_apoderados';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estudiante_id','apoderado_id','tipo'
    ];
    //RELACION DE UNO A MUCHOS INVERSA relacion-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA relacion-apoderado
    public function apoderado(){
        return $this->belongsTo('App\Apoderado','apoderado_id');
    }
}
