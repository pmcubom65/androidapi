<?php

namespace App\Http\Controllers;
use JD\Cloudder\Facades\Cloudder;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use App\Models\Archivo;
use App\Models\TipoArchivo;
use App\Models\Mensaje;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;


class ArchivoController extends Controller
{
    public function almacenar(Request $request) {


        $data = $request->json()->all();
        $id = $data["ID"];
        $base64_string=$data["IMAGEN"];
    
        $extension=$data["EXTENSION"];
        $dia=Carbon::parse($data["DIA"])->format('Y-m-d H:i:s');
        $chat_id=$data["CHAT_ID"];
        $emisor=$data["EMISOR"];
        $receptor=$data["RECEPTOR"];


        $dir='usuarios'.DIRECTORY_SEPARATOR.$id;





        if (! File::exists($dir)) {
            File::makeDirectory($dir,0777,true);
        }

        $path='';

        if($receptor === '' && $chat_id==='') {
            $path = $dir.DIRECTORY_SEPARATOR.$id.'.'.$extension;

            }else {
            $diamodificado = str_replace(":", "", $dia);
     
            $path = $dir.DIRECTORY_SEPARATOR.$id.$chat_id.$diamodificado.'.'.$extension;
    }

        $datos = explode(',', $base64_string);
          Storage::disk('s3')->put($path, base64_decode($datos[1]), 'public');
       
          $documentPath=  Storage::disk('s3')->url($path);
      
          Storage::disk('s3')->setVisibility($path,  'public');


        TipoArchivo::updateOrCreate(
            ['TIPO' => $extension]
        );


        $tipo = TipoArchivo::where('TIPO', '=', $extension)->first();

        $tipo->fresh();

        $miarchivo=New Archivo();
        $mimensaje=New Mensaje();


        $miarchivo->USUARIOID=$id;
   
        $miarchivo->TIPOID= $tipo->ID;
    
        $miarchivo->RUTA= str_replace("%5C", '/',$documentPath);
 

    


      if ($chat_id && $chat_id!=null) {
            $mimensaje->CHAT_ID=$chat_id;
            $mimensaje->DIA=$dia;
            $mimensaje->USUARIOID=$id;
            
            if ($receptor!=''){
                $mimensaje->IDUSUARIORECEPCION=$emisor;
            }

  

            $mimensaje->save();

            $mimensaje->fresh();
            
            
            $mensaje = DB::table('mensajes')->orderby('ID', 'desc')->first();

            $miarchivo->MENSAJE_ID=$mensaje->ID;
            $miarchivo->save();
        } else {
            $miarchivo->save();
        }

   
        $Response=['GRABADO' => 'Si', 'RUTA' => str_replace("%5C", '/',$documentPath)];

        return response()->json($Response,200);
 

    }




    public function buscarfoto(Request $request) {
        $data = $request->json()->all();
        $id = $data["ID"];


        $foto=Archivo::whereNull('MENSAJE_ID')->where('USUARIOID', '=', $id)->orderBy('ID', 'desc')->first();

        if ($foto){
            $Response=['RUTA' => $foto->RUTA];
        }else {
            $Response=['RUTA' => ''];
        }

        return response()->json($Response,200);

    }
}