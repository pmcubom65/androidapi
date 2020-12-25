<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/smartchat/crearusuario',
        '/api/smartchat/crearchat',
        '/api/smartchat/almacenarimagen',
        '/api/smartchat/almacenarrecuerdo',
        '/api/smartchat/damerecuerdos',
        '/api/smartchat/buscarfoto',
        '/api/smartchat/buscarusuario',
        '/api/smartchat/crearmensaje',
        '/api/smartchat/buscarmensajeschat',
        '/api/smartchat/creargrupo',
        '/api/smartchat/buscarGrupoPorID',
        '/api/smartchat/anadirusuarioagrupo',
        '/api/smartchat/misgrupos',
        '/api/smartchat/detallesmischats'
    ];
}
