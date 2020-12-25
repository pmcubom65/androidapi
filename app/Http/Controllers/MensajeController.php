<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use Carbon\Carbon;
use DB;

class MensajeController extends Controller
{
    public function crearmensaje(Request $request) {


        $data = $request->json()->all();

        $chat_id = $data["chatid"];
        $contenido=$data["contenido"];
     //   $dia=$data["dia"];

     $dia=Carbon::parse($data["dia"])->format('Y-m-d H:i:s');
    
        $usuarioid= $data["usuarioid"];
        $idusuariorecepcion= $data["idusuariorecepcion"];


        $mensaje=new Mensaje();

        $mensaje->CHAT_ID=$chat_id;
        $mensaje->CONTENIDO=$contenido;
        $mensaje->DIA=$dia;
        $mensaje->IDUSUARIORECEPCION=$idusuariorecepcion;
        $mensaje->USUARIOID=$usuarioid;

        $mensaje->save();

        $Response=['contenido'=>$contenido, 'id'=>$mensaje->ID];

        return response()->json($Response,200);

    }


    public function dameRecuerdos(Request $request) {

        $data = $request->json()->all();

        $id = $data["id"];


        $mensajes=DB::table('mensajes')->leftJoin('archivos', 'mensajes.ID', '=', 'archivos.MENSAJE_ID')->
        select ( DB::raw('mensajes.CONTENIDO as contenido') , DB::raw('mensajes.DIA as dia'), 
        DB::raw('archivos.RUTA as ruta')
       )->whereNull('mensajes.CHAT_ID')->where('mensajes.USUARIOID', '=', $id)
        ->orderBy('mensajes.DIA', 'desc')->get();
  
        //   Mensaje m=new Mensaje(explrObject.getString("contenido"), explrObject.getString("dia"), explrObject.getString("telefono"), explrObject.getString("nombre"), null);
  
        $Response=['mensajes'=>$mensajes];
  
        return response()->json($Response,200);




    }



  
    public function buscarmensajes(Request $request) {

        $data = $request->json()->all();

        $codigo = $data["codigo"];


     //   $query=" Select m.contenido, m.dia, u.telefono, u.nombre, a.ruta FROM mensajes m left join chatschat c on  m.chatid=c.id
     // join usuarios u on u.id=m.usuarioid left join archivos a on a.mensajeid=m.id
      //  WHERE  m.CHATID='$chat_id'; ";

      //$data = DB::select( DB::raw("SELECT * from records WHERE active ='1'") ); 

      $mensajes=DB::table('mensajes')->leftJoin('chatschat', 'mensajes.CHAT_ID', '=', 'chatschat.ID')->
      leftJoin('usuarios', 'mensajes.USUARIOID', '=', 'usuarios.ID')
      ->leftJoin('archivos', 'mensajes.ID', '=', 'archivos.MENSAJE_ID')->
      select ( DB::raw('mensajes.CONTENIDO as contenido') , DB::raw('mensajes.DIA as dia'), 
      DB::raw('usuarios.TELEFONO as telefono'), DB::raw('usuarios.NOMBRE as nombre'),
      DB::raw('archivos.RUTA as ruta')
     )
      ->where('mensajes.CHAT_ID', '=', $codigo)
      ->orderBy('mensajes.DIA', 'desc')->get();

      //   Mensaje m=new Mensaje(explrObject.getString("contenido"), explrObject.getString("dia"), explrObject.getString("telefono"), explrObject.getString("nombre"), null);

      $Response=['mensajes'=>$mensajes];

      return response()->json($Response,200);

    }


}
