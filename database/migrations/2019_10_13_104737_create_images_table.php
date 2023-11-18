<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
	    $table->engine = 'InnoDB';
	    
            $table->bigIncrements('id');
	    $table->string('name',50);
	    $table->integer('size', $autoIncrement=false);
	    $table->string('type',20);
	    $table->string('descricao',150);
	    $table->string('relacao',20);
	    $table->binary('conteudo');
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
        Schema::dropIfExists('images');
    }
}
