<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Entrevista extends Model
{
    protected $table='entrevistas';
    
    protected $fillable = [
        'fecha','observacion','user_id','estudiante_id','estado'
    ];
    //RELACION DE UNO A MUCHOS INVERSA entevista-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA entevista-estudiante
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    //FUNCION PARA TRAER LOS apoderados RELACIONADOS A UNA estudiante
    public function estudiantesporentrevista($id){
        $estudiantesporentrevista=DB::table('entrevistas')
        ->join('estudiantes', 'entrevistas.estudiante_id', '=', 'estudiantes.id')
        ->select('entrevistas.id','estudiantes.nombre','estudiantes.apellido')
        ->where('entrevistas.id',$id)
        ->get()
        ->groupBy('entrevistas.id');
  
        return $estudiantesporentrevista;
    }
}
