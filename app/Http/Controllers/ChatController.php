<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Carbon\Carbon;
use DB;

class ChatController extends Controller
{
    public function crearChat(Request $request) {


        $data = $request->json()->all();
        $codigo=$data['codigo'];
      //  $inicio=$data['inicio'];
      $inicio=Carbon::parse($data['inicio'])->format('Y-m-d H:i:s');
        
        $michat=new Chat();
        $michat->CODIGO=$codigo;
        $michat->INICIO=$inicio;


        $michat->save();

        $id=$michat->ID;

        $Response=['id'=>$id, 'codigo'=>$codigo, 'inicio'=>$inicio, 'idchat'=>$id];

        return response()->json($Response,200);

    }





    public function detalles(Request $request) {


        $data = $request->json()->all();
        $id=$data['ID'];



            $chatgrupo=DB::table('gruposchat')->select ('gruposchat.ID')->get();
         
            $idsgrupos=[];

            foreach ($chatgrupo as $p) {
              $idsgrupos[]= $p->ID;
              }
        
            $chats=   DB::table('chatschat')->leftJoin('mensajes', 'chatschat.ID', '=', 'mensajes.CHAT_ID')->
            leftJoin('usuarios', 'mensajes.IDUSUARIORECEPCION', '=', 'usuarios.ID')->
            select ('chatschat.INICIO', DB::raw('chatschat.ID as CODIGO') , 'usuarios.TELEFONO', 'usuarios.NOMBRE', 'usuarios.TOKEN', 'usuarios.ID' )
      ->where('mensajes.USUARIOID', '=', $id)->whereNotIn('chatschat.CODIGO',$idsgrupos)->get();


      $Response=['chats'=>$chats];



      return response()->json($Response,200);
    }
}
