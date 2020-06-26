<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\FichaSalud;

class FichaSaludController extends Controller
{
    public function index(){
        $fichasaluds=FichaSalud::where('estado','Activo')->get()->load('Estudiante');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'fichasaluds'=>$fichasaluds
        ]);
    }

    public function index2(){
        $fichasaluds=FichaSalud::where('estado','Inactivo')->get()->load('Estudiante');
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'fichasaluds'=>$fichasaluds
        ]);
    }

    public function show($id){
        $fichaSalud=FichaSalud::find($id);

        if(is_object($fichaSalud)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'fichaSalud'=>$fichaSalud
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La ficha Salud no existe'
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
                'nombre_sistema'=>'required',
                'medicamentos'=>'required',
                'observacion'=>'required',
                'estudiante_id' => 'required',
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado la ficha.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $fichasaluds=new FichaSalud();
                $fichasaluds->nombre_sistema= $params_array['nombre_sistema'];
                $fichasaluds->medicamentos= $params_array['medicamentos'];
                $fichasaluds->observacion= $params_array['observacion'];
                $fichasaluds->estudiante_id=$params_array['estudiante_id'];
                $fichasaluds->estado=$params_array['estado'];

                $fichasaluds->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'fichasalud'=> $fichasaluds
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
                'nombre_sistema'=>'required',
                'estudiante_id' => 'required',
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $fichaSalud=FichaSalud::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'fichaSalud'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna ficha.'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function destroy($id,Request $request){
        //conseguir el registro 
        $fichaSalud=FichaSalud::where('id',$id)->first();
        if(!empty($fichaSalud)){
            //Borrar el registro
            $fichaSalud->delete();
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'fichaSalud'=>$fichaSalud
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La ficha Salud no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function disable($id){

        //conseguir el registro 
        $fichasalud=FichaSalud::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($fichasalud)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'fichasalud'=>$fichasalud
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El fichasalud no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }
}
