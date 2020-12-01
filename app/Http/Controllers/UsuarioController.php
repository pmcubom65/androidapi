<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Usuario;
use DB;

class UsuarioController extends Controller
{
    
    public function crearusuario(Request $request) {


        $data = $request->json()->all();
        $telefono=$data['telefono'];
        $nombre=$data['nombre'];
        $token=$data['token'];
       DB::table('usuarios')->updateOrInsert(['TELEFONO' => $telefono], ['NOMBRE'=>$nombre, 'TOKEN'=>$token]);

      $usuario= Usuario::where('TELEFONO', '=', $telefono)->first();
      $Response=['id'=>$usuario->ID];
      return response()->json($Response,200);



  /* $usuario=new Usuario();
            $usuario->telefono=$telefono;
            $usuario->nombre=$nombre;
            $usuario->token=$token;
    
            $usuario->save();
    
            $id=$usuario->id;
    
            $Response=['id'=>$id];
    
            return response()->json($Response,200);*/

        
        


    }




    public function buscarusuario(Request $request) {


        $data = $request->json()->all();
        $telefono=$data['telefono'];


        $usuario=Usuario::where('TELEFONO', '=', $telefono)->first();

        $chatgrupo=DB::table('gruposchat')->select ('gruposchat.ID')->get();
         
        $idsgrupos=[];

        foreach ($chatgrupo as $p) {
          $idsgrupos[]= $p->ID;
          }
    




        if ($usuario){


            $chats= DB::table('chatschat')->leftJoin('mensajes', 'chatschat.ID', '=', 'mensajes.CHAT_ID')->
            leftJoin('usuarios', 'mensajes.IDUSUARIORECEPCION', '=', 'usuarios.ID')->
            select ('chatschat.CODIGO', 'chatschat.ID')
                ->where('mensajes.IDUSUARIORECEPCION', '=', $usuario->ID)->whereNotIn('chatschat.CODIGO',$idsgrupos)
                ->orderby('chatschat.CODIGO', 'desc')->first();


            $Response=['id'=>$usuario->ID, 
            'nombre'=>$usuario->NOMBRE,
            'telefono'=>$usuario->TELEFONO,
            'token'=>$usuario->TOKEN,
            'chat_id'=>(!$chats) ? '':$chats->ID
        ];



            return response()->json($Response,200);
        }



    }
}

