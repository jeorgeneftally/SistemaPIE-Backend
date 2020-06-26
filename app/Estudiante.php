<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estudiante extends Model
{
    protected $table='estudiantes';
    
    protected $fillable = [
        'rut','nombre','apellido','fecha_nacimiento','direccion','curso','personas_vive','imagen_perfil','imagen_genograma','estado'
    ];
    
    //RELACION UNO A MUCHOS estudiante-ficha
    public function fichaSalud(){
      return $this->hasMany('App\FichaSalud');
    }
     //relacion uno a muchos de estudinate-entrevista
     public function entrevista(){
      return $this->hasMany('App\Entrevista');
    }

    //relacion uno a muchos de estudiante-diagnostico
     public function diagnostico(){
      return $this->hasMany('App\Diagnostico');
    }
    //relacion uno a muchos de user-diagnostico
    public function estudiante_apoderado(){
      return $this->hasMany('App\EstudianteApoderado');
  }
    //relacion uno a muchos de estudinate-historial
    public function historial_academico(){
      return $this->hasMany('App\HistorialAcademico');
    }
    //relacion uno a muchos de estudinate-historial
    public function documento(){
      return $this->hasMany('App\Documento');
    }

    //FUNCION PARA TRAER LOS apoderados RELACIONADOS A UNA estudiante
    public function apoderadosporestudiante($id){
      $apoderadosporestudiante=DB::table('estudiantes')
      ->join('estudiantes_apoderados', 'estudiantes.id', '=', 'estudiantes_apoderados.estudiante_id')
      ->join('apoderados', 'apoderados.id', '=', 'estudiantes_apoderados.apoderado_id')
      ->select('estudiantes_apoderados.tipo','apoderados.nombre','apoderados.apellido','apoderados.telefono','apoderados.email','apoderados.actividad','apoderados.nivel_educacional','apoderados.direccion')
      ->where('estudiantes.id',$id)
      ->where('apoderados.estado','Activo')
      ->orderBy('apoderados.id', 'desc')
      ->get();

      return $apoderadosporestudiante;
    }

    //FUNCION PARA TRAER LOS apoderados RELACIONADOS A UNA estudiante
    public function fichaporestudiante($id){
      $fichaporestudiante=DB::table('estudiantes')
      ->join('fichas_salud', 'estudiantes.id', '=', 'fichas_salud.estudiante_id')
      ->select('fichas_salud.*')
      ->where('estudiantes.id',$id)
      ->where('fichas_salud.estado','Activo')
      ->get();

      return $fichaporestudiante;
    }

    //FUNCION PARA TRAER LOS diagnosticos RELACIONADOS A UNA estudiante
    public function diagnosticosporestudiante($id){
      $diagnosticosporestudiante=DB::table('estudiantes')
      ->join('diagnosticos', 'estudiantes.id', '=', 'diagnosticos.estudiante_id')
      ->join('users', 'diagnosticos.user_id', '=', 'users.id')
      ->select('diagnosticos.*','users.name','users.surname','users.profesion')
      ->where('estudiantes.id',$id)
      ->where('diagnosticos.estado','Activo')
      ->orderBy('id', 'desc')
      ->get();

      return $diagnosticosporestudiante;
  }

 //FUNCION PARA TRAER LOS diagnosticos RELACIONADOS A UNA estudiante
 public function doc($id){
  $doc=DB::table('estudiantes')
  ->join('documentos', 'estudiantes.id', '=', 'documentos.estudiante_id')
  ->select('documentos.*')
  ->where('estudiantes.id',$id)
  ->where('documentos.estado','Activo')
  ->orderBy('id', 'desc')
  ->get();

  return $doc;
}


  //FUNCION PARA TRAER LOS diagnosticos RELACIONADOS A UNA estudiante
  public function entrevistasporestudiante($id){
    $entrevistasporestudiante=DB::table('estudiantes')
    ->join('entrevistas', 'estudiantes.id', '=', 'entrevistas.estudiante_id')
    ->join('users', 'entrevistas.user_id', '=', 'users.id')
    ->select('entrevistas.*','users.name','users.surname','users.profesion')
    ->where('estudiantes.id',$id)
    ->where('entrevistas.estado','Activo')
    ->orderBy('id', 'desc')
    ->get();

    return $entrevistasporestudiante;
}

  //FUNCION PARA TRAER LOS apoderados RELACIONADOS A UNA estudiante
  public function documentosporestudiante($id){
    $documentosporestudiante=DB::table('estudiantes')
    ->join('documentos', 'estudiantes.id', '=', 'documentos.estudiante_id')
    ->select('documentos.*')
    ->where('estudiantes.id',$id)
    ->where('documentos.estado','Activo')
    ->orderBy('id', 'desc')
    ->get();

    return $documentosporestudiante;
  }

  //FUNCION PARA TRAER LOS apoderados RELACIONADOS A UNA estudiante
  public function historialporestudiante($id){
    $historialporestudiante=DB::table('estudiantes')
    ->join('historiales_academicos', 'estudiantes.id', '=', 'historiales_academicos.estudiante_id')
    ->select('historiales_academicos.*')
    ->where('estudiantes.id',$id)
    ->where('historiales_academicos.estado','Activo')
    ->get();

    return $historialporestudiante;
  }
}
