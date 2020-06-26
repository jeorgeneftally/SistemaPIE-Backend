<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table='documentos';
    
    protected $fillable = [
        'certificado_nac','autorizacion_padres',
        'derivacion','anamnesis','pruebas','protocolos',
        'formulario_ingreso','valoracion_salud','fonoaudilogico',
        'psicopedagogico','psicologico','neurologico','estudiante_id','estado'
    ];

    //RELACION DE UNO A MUCHOS INVERSA fichasalud-estudiante
    public function estudiante(){
        return $this->belongsTo('App\Estudiante','estudiante_id');
    }
}