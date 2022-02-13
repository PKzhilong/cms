<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyDiyPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_diy_page', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->string('page_path',100)->index();
            $table->string('page_title')->nullable();
            $table->string('page_keyword')->nullable();
            $table->string('page_desc')->nullable();
            $table->longText('page_content');

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
        Schema::dropIfExists('my_diy_page');
    }
}
