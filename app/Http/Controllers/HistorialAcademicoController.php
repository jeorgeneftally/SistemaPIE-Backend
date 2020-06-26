<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\HistorialAcademico;

class HistorialAcademicoController extends Controller
{
    public function index(){
        $historial=HistorialAcademico::where('estado','Activo')->get()->load('Estudiante');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'historial'=>$historial
        ]);
    }

    public function index2(){
        $historial=HistorialAcademico::where('estado','Inactivo')->get()->load('Estudiante');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'historial'=>$historial
        ]);
    }

    public function show($id){
        $historial=HistorialAcademico::find($id);

        if(is_object($historial)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'historial'=>$historial
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El historial no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }


      /**
     * store guarda una nueva ficha en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'ingreso_cpc'=>'required',
                'ingreso_pie'=>'required',
                
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el diagnostico.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $historial=new HistorialAcademico();
                $historial->ingreso_cpc= $params_array['ingreso_cpc'];
                $historial->ingreso_pie= $params_array['ingreso_pie'];
                $historial->colegio_anterior= $params_array['colegio_anterior'];
                $historial->curso_repetido= $params_array['curso_repetido'];
                $historial->activid_extraprogra= $params_array['activid_extraprogra'];
                $historial->estudiante_id=$params_array['estudiante_id'];
                $historial->estado=$params_array['estado'];
                $historial->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'historial'=> $historial
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun historial'
            ];
        }
        return response()->json($data,$data['code']);
    }
    /**
     * update permite actualizar un modelo en la base de datos
     */
    public function update($id,Request $request){

        //Recoger datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //Validar los datos
            $validate=\Validator::make($params_array,[
                'ingreso_cpc'=>'required',
                'ingreso_pie'=>'required',
                'colegio_anterior'=>'required',
                'curso_repetido'=>'required',
                'activid_extraprogra'=>'required',
                'estudiante_id' => 'required'
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $historial=HistorialAcademico::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'historial'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun historial.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $historial=HistorialAcademico::where('id',$id)->first();
        if(!empty($historial)){

            //Borrar el registro
            $historial->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'historial'=>$historial
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El historial no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function disable($id){

        //conseguir el registro 
        $historial=HistorialAcademico::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($historial)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'historial'=>$historial
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El historial no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }


    //funcion para recibir los productos por cliente recibiendo el id del cliente
public function ingresos(){
    $ingresos=HistorialAcademico::first()->ingresos();

    if(is_object($ingresos)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'ingresos'=>$ingresos
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'No hay'
        );
    }
    return response()->json($data,$data['code']);
}
    
}
