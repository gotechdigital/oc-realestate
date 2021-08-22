<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateV116 extends Migration
{
    public function up()
    {
        Schema::table('awebsome_realestate_realty', function(Blueprint $table) {
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
        });
    }

    public function down()
    {
        Schema::table('awebsome_realestate_realty', function(Blueprint $table) {
            $table->dropColumn("latitude");
            $table->dropColumn("longitude");
        });
    }
}
