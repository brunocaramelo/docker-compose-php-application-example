<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_disciplines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')
                ->foreign('book_id')
                ->references('id')
                ->on('books');
            
            $table->integer('discipline_id')
                ->foreign('discipline_id')
                ->references('id')
                ->on('disciplines');
                
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
        Schema::dropIfExists('book_disciplines');
    }
}
