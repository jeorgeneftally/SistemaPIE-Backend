<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaSalud extends Model
{
    protected $table='fichas_salud';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_sistema','medicamentos','observacion','estudiante_id','estado'
    ];


    //RELACION DE UNO A MUCHOS INVERSA fichasalud-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }
}
