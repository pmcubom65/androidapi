<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo_Usuario extends Model
{
    use HasFactory;
    protected $table = 'gruposchat_usuario';
    protected $primaryKey = 'ID';
}
