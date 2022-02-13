<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyUrlFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_url_format', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 50);
            $table->string('alias', 100);
            $table->integer('foreign_id');
            $table->index(['model_type', 'foreign_id']);
            $table->index(['model_type', 'alias']);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_url_format');
    }
}
