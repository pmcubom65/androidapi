<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'TELEFONO'=>'3333333',
            'TOKEN'=>'000000',
            'NOMBRE'=>'AAAAAA'
        ]);
    }
}
