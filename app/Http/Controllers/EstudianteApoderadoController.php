<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\EstudianteApoderado;

class EstudianteApoderadoController extends Controller
{
    public function index(){
        $estudianteapoderado=EstudianteApoderado::all()->load('Estudiante','Apoderado');

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'estudianteapoderado'=>$estudianteapoderado
        ],200);
    }

    public function show($id){
        $estudianteapoderado=EstudianteApoderado::find($id);

        if(is_object($estudianteapoderado)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'estudianteapoderado'=>$estudianteapoderado
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La estudianteapoderado no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

     
    /**
     * store guarda un nuevo estudianteapoderado en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'estudiante_id'=>'required',
                'apoderado_id' => 'required'
            ]);

            //guardar el estudiante
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado la relacion.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $estudianteapoderado=new EstudianteApoderado();
                $estudianteapoderado->id= $params_array['id'];
                $estudianteapoderado->estudiante_id= $params_array['estudiante_id'];
                $estudianteapoderado->apoderado_id=$params_array['apoderado_id'];
                $estudianteapoderado->tipo=$params_array['tipo'];
                $estudianteapoderado->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'estudianteapoderado'=> $estudianteapoderado
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun estudianteapoderado.'
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
                'id'=>'required',
                'estudiante_id'=>'required',
                'apoderado_id' => 'required'
            ]);

            //quitar los datos que no quiero actualizar
           // unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $estudianteapoderado=EstudianteApoderado::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'estudianteapoderado'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna estudianteapoderado.'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function destroy($id,Request $request){
        //conseguir el registro 
        $estudianteapoderado=EstudianteApoderado::where('id',$id)->first();
        if(!empty($estudianteapoderado)){

            //Borrar el registro
            $estudianteapoderado->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'estudianteapoderado'=>$estudianteapoderado
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La relación estudiante-apoderado no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
}
