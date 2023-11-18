<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome',150);
            $table->date('nascimento')->nullable();
            $table->enum('sexo', ['M','F']);
            $table->string('email',150)->nullable();
            $table->string('telefone', 13)->nullable();
            $table->string('celular', 14)->nullable();
            $table->string('cpf', 14)->unique()->nullable();
            $table->string('rg')->nullable();
            $table->string('rg_orgao')->nullable();
            $table->string('rg_uf',2)->nullable();
            $table->date('rg_data')->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('endereco',150)->nullable();
            $table->integer('numero', $autoIncrement=false)->nullable();
            $table->string('complemento',50)->nullable();
            $table->string('bairro',50)->nullable();
            $table->string('uf',2)->nullable();
            $table->string('municipio',50)->nullable();
            $table->string('turmas',200)->nullable();
	        $table->bigInteger('image_id')->unsigned();
	        $table->foreign('image_id')
		        ->references('id')
		        ->on('images')
		        ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professors');
    }
}
