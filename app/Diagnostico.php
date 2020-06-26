<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table='diagnosticos';
    
    protected $fillable = [
        'id','fecha_autorizacion','fecha_evaluacion','fecha_reevaluacion','nee_postulada','tipo_nee','derivacion','observacion','estudiante_id','user_id','estado'
    ];

    //RELACION DE UNO A MUCHOS INVERSA fichasalud-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA fichasalud-estudiante
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }


  
}
