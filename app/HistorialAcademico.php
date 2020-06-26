<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistorialAcademico extends Model
{
    protected $table='historiales_academicos';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ingreso_cpc','ingreso_pie','colegio_anterior','curso_repetido','activid_extraprogra','estudiante_id','estado'
    ];


    //RELACION DE UNO A MUCHOS INVERSA fichasalud-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }

      //FUNCION PARA TRAER LOS diagnosticos RELACIONADOS A UNA estudiante
  public function ingresos(){
    $ingresos=DB::table('historiales_academicos')  ->whereYear('ingreso_pie', '2010')
    ->get();

    return $ingresos;
}
}
