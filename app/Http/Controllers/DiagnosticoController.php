<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Diagnostico;

class DiagnosticoController extends Controller
{
    public function index(){
        $diagnosticos=Diagnostico::where('estado','Activo')->get()->load('Estudiante','User');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'diagnosticos'=>$diagnosticos
        ]);
    }

    public function index2(){
        $diagnosticos=Diagnostico::where('estado','Inactivo')->get()->load('Estudiante','User');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'diagnosticos'=>$diagnosticos
        ]);
    }

    public function show($id){
        $diagnostico=Diagnostico::find($id);

        if(is_object($diagnostico)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'diagnostico'=>$diagnostico
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El diagnostico no existe'
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
                'fecha_autorizacion'=>'required',
                'derivacion'=>'required',
                'observacion'=>'required'
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
                $diagnosticos=new Diagnostico();
                $diagnosticos->fecha_autorizacion= $params_array['fecha_autorizacion'];
                $diagnosticos->fecha_evaluacion= $params_array['fecha_evaluacion'];
                $diagnosticos->fecha_reevaluacion= $params_array['fecha_reevaluacion'];
                $diagnosticos->nee_postulada= $params_array['nee_postulada'];
                $diagnosticos->tipo_nee= $params_array['tipo_nee'];
                $diagnosticos->derivacion= $params_array['derivacion'];
                $diagnosticos->observacion= $params_array['observacion'];
                $diagnosticos->user_id= $params_array['user_id'];
                $diagnosticos->estudiante_id=$params_array['estudiante_id'];
                $diagnosticos->estado=$params_array['estado'];
                $diagnosticos->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'diagnostico'=> $diagnosticos
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna ficha.'
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
                'fecha_autorizacion'=>'required',
                'user_id' => 'required',
                'estudiante_id' => 'required'
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $diagnostico=Diagnostico::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'diagnostico'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun diagnostico.'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

    public function destroy($id,Request $request){
        //conseguir el registro 
        $diagnostico=Diagnostico::where('id',$id)->first();
        if(!empty($diagnostico)){
            //Borrar el registro
            $diagnostico->delete();
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'diagnostico'=>$diagnostico
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El diagnostico no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function disable($id){

        //conseguir el registro 
        $diagnostico=Diagnostico::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($diagnostico)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'diagnostico'=>$diagnostico
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El diagnostico no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }
}
