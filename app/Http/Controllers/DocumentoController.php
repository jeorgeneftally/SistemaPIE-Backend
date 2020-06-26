<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Documento;

class DocumentoController extends Controller
{
    public function index(){
        $documentos=Documento::where('estado','Activo')->get()->load('Estudiante');

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'documentos'=>$documentos
        ],200);
    }
    public function index2(){
        $documentos=Documento::where('estado','Inactivo')->get()->load('Estudiante');

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'documentos'=>$documentos
        ],200);
    }

    public function show($id){
        $documentos=Documento::find($id);

        if(is_object($documentos)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'documento'=>$documentos
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El documento no existe'
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
                'estudiante_id'=>'required'
            ]);

            //guardar el estudiante
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el estudiante.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $documento=new Documento();
                $documento->id= $params_array['id'];
                $documento->certificado_nac= $params_array['certificado_nac'];
                $documento->autorizacion_padres=$params_array['autorizacion_padres'];
                $documento->derivacion=$params_array['derivacion'];
                $documento->anamnesis=$params_array['anamnesis'];
                $documento->pruebas=$params_array['pruebas'];
                $documento->protocolos=$params_array['protocolos'];
                $documento->formulario_ingreso=$params_array['formulario_ingreso'];
                $documento->valoracion_salud=$params_array['valoracion_salud'];
                $documento->fonoaudiologico=$params_array['fonoaudiologico'];
                $documento->psicopedagogico=$params_array['psicopedagogico'];
                $documento->psicologico=$params_array['psicologico'];
                $documento->neurologico=$params_array['neurologico'];
                $documento->estudiante_id=$params_array['estudiante_id'];
                $documento->estado=$params_array['estado'];
                $documento->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'documento'=> $documento
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun estudiante.'
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
                'estudiante_id'=>'required'
            ]);

            //quitar los datos que no quiero actualizar
           // unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $documento=Documento::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'documento'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna documento.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    
    public function destroy($id,Request $request){
        //conseguir el registro 
        $documento=Documento::where('id',$id)->first();
        if(!empty($diagnostico)){
            //Borrar el registro
            $documento->delete();
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'documento'=>$documento
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El documento no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function disable($id){

        //conseguir el registro 
        $documento=Documento::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($documento)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'documento'=>$documento
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El documento no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }
}
