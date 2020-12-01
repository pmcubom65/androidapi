<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->timestamps();
            $table->string('RUTA');
            $table->unsignedBigInteger('MENSAJE_ID')->nullable()->unsigned();
            $table->unsignedBigInteger('TIPOID')->unsigned();
            $table->unsignedBigInteger('USUARIOID')->unsigned();
           

            $table->foreign('MENSAJE_ID')
            ->references('ID')
            ->on('mensajes')
            ->onDelete('cascade');

            
            $table->foreign('USUARIOID')
            ->references('ID')
            ->on('usuarios')
            ->onDelete('cascade');


            $table->foreign('TIPOID')
            ->references('ID')
            ->on('archivos')
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
        Schema::dropIfExists('archivos');
    }
}
