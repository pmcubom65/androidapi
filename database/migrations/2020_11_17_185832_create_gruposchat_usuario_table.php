<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposchatUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gruposchat_usuario', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->timestamps();


            $table->unsignedBigInteger('GRUPOID')->unsigned();
    
            $table->unsignedBigInteger('USUARIOID')->unsigned();

            $table->foreign('GRUPOID')
            ->references('ID')
            ->on('gruposchat')
            ->onDelete('cascade');

            
            $table->foreign('USUARIOID')
            ->references('id')
            ->on('usuarios')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gruposchat_usuario');
    }
}
