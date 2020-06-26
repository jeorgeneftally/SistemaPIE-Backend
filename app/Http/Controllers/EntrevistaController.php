<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Entrevista;

class EntrevistaController extends Controller
{
    public function index(){
        $entrevistas=Entrevista::where('estado','Activo')->get()->load('Estudiante','User');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'entrevistas'=>$entrevistas
        ]);
    }

    public function index2(){
        $entrevistas=Entrevista::where('estado','Inactivo')->get()->load('Estudiante','User');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'entrevistas'=>$entrevistas
        ]);
    }

    public function show($id){
        $entrevista=Entrevista::find($id);

        if(is_object($entrevista)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'entrevista'=>$entrevista
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La entrevista no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
     
    /**
     * store guarda un nuevo estudiante en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'estudiante_id' => 'required',
            ]);

            //guardar el estudiante
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado la entrevista.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $entrevista=new Entrevista();
                $entrevista->id= $params_array['id'];
                $entrevista->fecha= $params_array['fecha'];
                $entrevista->observacion=$params_array['observacion'];
                $entrevista->user_id=$params_array['user_id'];
                $entrevista->estudiante_id=$params_array['estudiante_id'];
                $entrevista->estado=$params_array['estado'];
                $entrevista->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'entrevista'=> $entrevista
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna entrevista.'
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
                'user_id' => 'required',
                'estudiante_id' => 'required',
            ]);

            //quitar los datos que no quiero actualizar
           // unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $entrevista=Entrevista::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'entrevista'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna estudiante.'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function destroy($id,Request $request){
        //conseguir el registro 
        $entrevista=Entrevista::where('id',$id)->first();
        if(!empty($entrevista)){

            //Borrar el registro
            $entrevista->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'entrevista'=>$entrevista
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El entrevista no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }


     //funcion para recibir los productos por cliente recibiendo el id del cliente
     public function estudiantesporentrevista(){
        $estudiante=Entrevista::all()->estudiantesporentrevista($id);

        if(is_object($estudiante)){
            $data=array(
                'code'=>200,
                'status'=>'success',
                'estudiante'=>$estudiante
            );
        }else{
            $data=array(
                'code'=>404,
                'status'=>'error',
                'message'=>'La entrevista no tiene estudiantes asociados'
            );
        }
        return response()->json($data,$data['code']);
    }

    public function disable($id){

        //conseguir el registro 
        $entrevista=Entrevista::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($entrevista)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'entrevista'=>$entrevista
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El entrevista no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }
}
