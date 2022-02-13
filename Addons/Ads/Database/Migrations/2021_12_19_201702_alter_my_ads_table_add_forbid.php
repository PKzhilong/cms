<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyAdsTableAddForbid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_ads', function (Blueprint $table) {
            $table->string('forbid_img')->after('content')->nullable();
            $table->string('forbid_url')->after('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_ads', function (Blueprint $table) {
            $table->dropColumn(['forbid_img', 'forbid_url']);
        });
    }
}
