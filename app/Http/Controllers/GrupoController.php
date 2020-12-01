<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;

use DB;

use App\Models\Usuario;

use App\Models\Grupo_Usuario;

class GrupoController extends Controller
{
    public function creargrupo(Request $request) {


        $data = $request->json()->all();
        $nombre=$data['nombre'];

        $grupo=new Grupo();
        $grupo->NOMBRE=$nombre;

        $grupo->save();


        $Response=['ID'=>$grupo->id, 'NOMBRE'=>$grupo->NOMBRE];

        return response()->json($Response,200);
}


public function anadiragrupo(Request $request) {

    $data = $request->json()->all();
    $id=$data['id'];
    $grupo=$data['grupo'];


    $grupousuario=new Grupo_Usuario();

    $grupo=Grupo::where('NOMBRE', '=', $grupo)->first();
    $usuario=Usuario::where('ID', '=', $id)->first();

    $Response=[];

    if ($grupo && $usuario){
        $grupousuario->GRUPOID=$grupo->ID;
        $grupousuario->USUARIOID=$id;
    
        $grupousuario->save();
    
        $Response=['grupo'=>$grupo->NOMBRE];
    }



    return response()->json($Response,200);

}



public function buscargrupo(Request $request) {

    $data = $request->json()->all();
    $id=$data['ID'];


    $elcodigo=DB::table('chatschat')->select('chatschat.CODIGO')->where('chatschat.ID','=',$id)->first();


    $grupo=Grupo::where('ID', '=', $elcodigo->CODIGO)->first();


    if ($grupo) {

      //  $querymiembros=" Select u.NOMBRE, u.TOKEN, u.TELEFONO, u.ID As 'USUARIOID' from usuarios u,
      // gruposchat_usuario g where g.usuarioid=u.id 
      //  and g.GRUPOID='$id';";

      //	$salida = array('ID' => $miid, 'NOMBRE'=> $minombre, 'MIEMBROS'=>$temp_array);


      $miembros=DB::table('gruposchat_usuario')->leftJoin('usuarios', 'gruposchat_usuario.USUARIOID', '=', 'usuarios.ID')->
      select ('usuarios.NOMBRE', 'usuarios.TOKEN', 'usuarios.TELEFONO', DB::raw('usuarios.ID as USUARIOID'))
      ->where('gruposchat_usuario.GRUPOID', '=', $elcodigo->CODIGO)->get();


      $Response=['ID'=>$id, 'NOMBRE'=>$grupo->NOMBRE, 'MIEMBROS'=>$miembros];

      return response()->json($Response,200);

    }


}


public function misgrupos(Request $request) {

    $data = $request->json()->all();
    $id=$data['ID'];


    $grupos=DB::table('gruposchat_usuario')->leftJoin('gruposchat', 'gruposchat_usuario.GRUPOID', '=', 'gruposchat.ID')->
    select ('gruposchat.NOMBRE', DB::raw('gruposchat.ID as ID') )
    ->where('gruposchat_usuario.USUARIOID', '=', $id)->get();

    $Response=[];

//		$querymiembros=" Select u.NOMBRE, u.TELEFONO, u.TOKEN, u.ID AS USUARIOID FROM usuarios u, gruposchat_usuario gu 
//where u.id=gu.USUARIOID and gu.GRUPOID='$idgrupo' ;";


    foreach($grupos as $g){

        $elcodigo=DB::table('chatschat')->select('chatschat.ID')->where('chatschat.CODIGO','=',$g->ID)->first();

        $Response[]=[
            'NOMBRE'=>$g->NOMBRE,
            'ID'=>$elcodigo->ID,
            'MIEMBROS'=>DB::table('gruposchat_usuario')->leftJoin('usuarios', 'gruposchat_usuario.USUARIOID', '=', 'usuarios.ID')->
      select ('usuarios.NOMBRE','usuarios.TOKEN', 'usuarios.TELEFONO', DB::raw('usuarios.ID as USUARIOID') )
      ->where('gruposchat_usuario.GRUPOID', '=', $g->ID)->get()
    
    
    
    
    
        ];
    }

    $asi=['GRUPOS'=>$Response];

    return response()->json($asi,200);
}
}