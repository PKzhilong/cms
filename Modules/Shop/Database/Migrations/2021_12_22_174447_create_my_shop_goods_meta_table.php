<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyShopGoodsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_shop_goods_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('goods_id');
            $table->string('meta_key',50);
            $table->text('meta_value');
            $table->index(['goods_id','meta_key']);
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
        Schema::dropIfExists('my_shop_goods_meta');
    }
}
