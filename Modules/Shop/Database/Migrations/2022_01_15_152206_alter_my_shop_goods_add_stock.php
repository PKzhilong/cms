<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyShopGoodsAddStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_shop_goods', function (Blueprint $table) {
            $table->integer('stock')->after('view')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_shop_goods', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
}
