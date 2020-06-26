<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Estudiante;

class EstudianteController extends Controller
{
    public function index(){
        $estudiantes=Estudiante::where('estado','Activo')->get()->load('Entrevista','FichaSalud');

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'estudiantes'=>$estudiantes
        ],200);
    }
    public function index2(){
        $estudiantes=Estudiante::where('estado','Inactivo')->get()->load('Entrevista','FichaSalud');

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'estudiantes'=>$estudiantes
        ],200);
    }

    public function show($id){
        $estudiante=Estudiante::find($id);

        if(is_object($estudiante)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'estudiante'=>$estudiante
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La estudiante no existe'
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
                'rut'=>'required',
                'nombre' => 'required',
                'apellido' => 'required',
                    
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
                $estudiante=new Estudiante();
              
                $estudiante->rut= $params_array['rut'];
                $estudiante->nombre=$params_array['nombre'];
                $estudiante->apellido=$params_array['apellido'];
                $estudiante->fecha_nacimiento=$params_array['fecha_nacimiento'];
                $estudiante->direccion=$params_array['direccion'];
                $estudiante->curso=$params_array['curso'];
                $estudiante->personas_vive=$params_array['personas_vive'];
                $estudiante->estado=$params_array['estado'];
                $estudiante->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'estudiante'=> $estudiante
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
                'rut'=>'required',
                'nombre' => 'required',
                'apellido' => 'required'
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $estudiante=Estudiante::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'estudiante'=>$params_array
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


      /**
     * upload permite guardar una nueva imagen en la base de datos
     */
    public function upload(Request $request){

        //Recoger datos de la petición
        $imagen=$request->file('file0');

        //validación de la imagen
        $validate=\Validator::make($request->all(),[
            'file0'=>'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //Guardar imagen
        if(!$imagen || $validate->fails()){

            $data=array(
                'code'=>400,
                'status'=>'error',
                'message'=>'Error al subir imagen'
            );
            
        }else{

            //asignar nombre a la imagen
            $image_name=time().$imagen->getClientOriginalName();
            //guarda la imagen en el servidor, especificando la carpeta en este caso storage\app\products,
            //la carpeta products se debe configurar en filesystems.php para permitir que almacene archivos
            \Storage::disk('estudiantes')->put($image_name,\File::get($imagen)); 
        
            $data=array(
                'code'=>200,
                'status'=>'success',
                'image'=>$image_name,
            );

        }

        return response()->json($data,$data['code']);
    }

    /**
     * getImage retorna la imagen almacenada en el servidor para ello debe recibir el nombre de la imagen
     * y buscarla en la carpeta especificada
     */
    public function getImage($filename){
        //verificar si existe el archivo
        $isset=\Storage::disk('estudiantes')->exists($filename);  
        if($isset){
            $file=\Storage::disk('estudiantes')->get($filename);
            return new Response($file,200);
        }else{
            $data=array(
                'code'=>404,
                'status'=>'error',
                'message'=>'La imagen no existe',
            );

            return response()->json($data,$data['code']);
        }
    }



     //funcion para recibir los productos por cliente recibiendo el id del cliente
     public function apoderadosporestudiante($id){
        $apoderados=Estudiante::first()->apoderadosporestudiante($id);

        if(is_object($apoderados)){
            $data=array(
                'code'=>200,
                'status'=>'success',
                'apoderados'=>$apoderados
            );
        }else{
            $data=array(
                'code'=>404,
                'status'=>'error',
                'message'=>'El estudiante no tiene apoderados asociados'
            );
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $estudiante=Estudiante::where('id',$id)->first();
        if(!empty($estudiante)){

            //Borrar el registro
            $estudiante->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'estudiante'=>$estudiante
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El estudiante no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function disable($id){

        //conseguir el registro 
        $estudiante=Estudiante::where('id',$id)->update(['estado'=>'Inactivo']);

        if(!empty($estudiante)){

            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'estudiante'=>$estudiante
            ];

        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El estudiante no existe'
            ];
        }
        

        return response()->json($data,$data['code']);
    }

    
//funcion para recibir los productos por cliente recibiendo el id del cliente
public function diagnosticosporestudiante($id){
    $diagnosticos=Estudiante::first()->diagnosticosporestudiante($id);
    if(is_object($diagnosticos)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'diagnosticos'=>$diagnosticos
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene diagnosticos asociados'
        );
    }
    return response()->json($data,$data['code']);
}

//funcion para recibir los productos por cliente recibiendo el id del cliente
public function ultimodiagnostico($id){
    $diagnosticos=Estudiante::first()->diagnosticosporestudiante($id)->last();
   
    if(is_object($diagnosticos)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'diagnosticos'=>$diagnosticos
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene diagnosticos asociados'
        );
    }
    return response()->json($data,$data['code']);
}


//funcion para recibir los productos por cliente recibiendo el id del cliente
public function doc($id){
    $doc=Estudiante::first()->doc($id)->last();
   
    if(is_object($doc)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'doc'=>$doc
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene documento asociados'
        );
    }
    return response()->json($data,$data['code']);
}
//funcion para recibir los productos por cliente recibiendo el id del cliente
public function fichasporestudiante($id){
    $fichas=Estudiante::first()->fichaporestudiante($id);

    if(is_object($fichas)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'fichas'=>$fichas
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene fichas asociadas'
        );
    }
    return response()->json($data,$data['code']);
}
//funcion para recibir los productos por cliente recibiendo el id del cliente
public function documentosporestudiante($id){
    $documentos=Estudiante::first()->documentosporestudiante($id);

    if(is_object($documentos)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'documentos'=>$documentos
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene documentos asociadas'
        );
    }
    return response()->json($data,$data['code']);
}


//funcion para recibir los productos por cliente recibiendo el id del cliente
public function historialporestudiante($id){
    $historial=Estudiante::first()->historialporestudiante($id);

    if(is_object($historial)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'historial'=>$historial
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene historial asociadas'
        );
    }
    return response()->json($data,$data['code']);
}
//funcion para recibir los productos por cliente recibiendo el id del cliente
public function entrevistasporestudiante($id){
    $entrevistas=Estudiante::first()->entrevistasporestudiante($id);

    if(is_object($entrevistas)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'entrevistas'=>$entrevistas
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'El estudiante no tiene entrevistas asociadas'
        );
    }
    return response()->json($data,$data['code']);
}


}
