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

            $table->unsignedBigInteger('CHAT_ID')->unsigned();
            $table->unsignedBigInteger('IDUSUARIORECEPCION')->unsigned();
            $table->unsignedBigInteger('USUARIOID')->unsigned();
   

            $table->foreign('CHAT_ID')
            ->references('ID')
            ->on('CHATSCHAT')
            ->onDelete('cascade');

            
            $table->foreign('usuarioid')
            ->references('id')
            ->on('usuarios')
            ->onDelete('cascade');

            $table->foreign('idusuariorecepcion')
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
        Schema::dropIfExists('mensajes');
    }
}
