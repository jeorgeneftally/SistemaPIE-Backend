<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Apoderado;


class ApoderadoController extends Controller
{
    public function index(){
        $apoderados=Apoderado::where('estado','Activo')->get();

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'apoderados'=>$apoderados
        ],200);
    }
    public function index2(){
        $apoderados=Apoderado::where('estado','Inactivo')->get();

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'apoderados'=>$apoderados
        ],200);
    }

    public function show($id){
        $apoderado=Apoderado::find($id);

        if(is_object($apoderado)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'apoderado'=>$apoderado
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'el apoderado no existe'
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
               
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'required'
                
                
            ]);

            //guardar el apoderado
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el apoderado.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $apoderado=new Apoderado();
                $apoderado->id= $params_array['id'];
                $apoderado->nombre=$params_array['nombre'];
                $apoderado->apellido=$params_array['apellido'];
                $apoderado->telefono=$params_array['telefono'];
                $apoderado->email=$params_array['email'];
                $apoderado->parentesco=$params_array['parentesco'];
                $apoderado->actividad=$params_array['actividad'];
                $apoderado->direccion=$params_array['direccion'];
                $apoderado->nivel_Educacional=$params_array['nivel_educacional'];
                $apoderado->estado=$params_array['estado'];
                $apoderado->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'apoderado'=> $apoderado
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun apoderado.'
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
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'required'
            
                
            ]);

            //quitar los datos que no quiero actualizar
            //unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $apoderado=Apoderado::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'apoderado'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna apoderado.'
            ];
        }
        return response()->json($data,$data['code']);
    }
    public function disable($id){

        //conseguir el registro 
        $apoderado=Apoderado::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($apoderado)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'apoderado'=>$apoderado
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El apoderado no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }
}
