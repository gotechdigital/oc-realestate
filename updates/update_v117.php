<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateV117 extends Migration
{
    public function up()
    {
        Schema::table('awebsome_realestate_realty', function(Blueprint $table) {
            $table->string("code")->index()->nullable();
            $table->string("tag")->nullable();
        });
    }

    public function down()
    {
        Schema::table('awebsome_realestate_realty', function(Blueprint $table) {
            $table->dropColumn("code");
            $table->dropColumn("tag");
        });
    }
}
