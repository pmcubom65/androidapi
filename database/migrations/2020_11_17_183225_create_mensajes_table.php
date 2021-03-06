<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->timestamps();
            $table->string('CONTENIDO')->nullable();
            $table->dateTime('DIA');

            $table->unsignedBigInteger('CHAT_ID')->unsigned()->nullable();
            $table->unsignedBigInteger('IDUSUARIORECEPCION')->unsigned()->nullable();
            $table->unsignedBigInteger('USUARIOID')->unsigned();
   

            $table->foreign('CHAT_ID')
            ->references('ID')
            ->on('chatschat')
            ->onDelete('cascade');

            
            $table->foreign('USUARIOID')
            ->references('ID')
            ->on('usuarios')
            ->onDelete('cascade');

            $table->foreign('IDUSUARIORECEPCION')
            ->references('ID')
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
        Schema::dropIfExists('mensajes');
    }
}
