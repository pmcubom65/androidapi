<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArchivo extends Model
{
    use HasFactory;
    protected $table = 'tipos_archivos';

    protected $fillable = ['TIPO'];
    protected $primaryKey = 'ID';
}
