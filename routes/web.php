<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'hola';
});



Route::post('/api/smartchat/crearusuario', 'UsuarioController@crearUsuario');

Route::post('/api/smartchat/buscarusuario', 'UsuarioController@buscarusuario');

Route::post('/api/smartchat/crearchat', 'ChatController@crearChat');



Route::post('/api/smartchat/almacenarimagen', 'ArchivoController@almacenar');


Route::post('/api/smartchat/buscarfoto', 'ArchivoController@buscarfoto');


Route::post('/api/smartchat/crearmensaje', 'MensajeController@crearmensaje');


Route::post('/api/smartchat/buscarmensajeschat', 'MensajeController@buscarmensajes');

Route::post('/api/smartchat/creargrupo', 'GrupoController@creargrupo');



Route::post('/api/smartchat/buscarGrupoPorID', 'GrupoController@buscargrupo');


Route::post('/api/smartchat/anadirusuarioagrupo', 'GrupoController@anadiragrupo');


Route::post('/api/smartchat/detallesmischats', 'ChatController@detalles');

Route::post('/api/smartchat/misgrupos', 'GrupoController@misgrupos');