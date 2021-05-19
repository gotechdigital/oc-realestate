<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateV115 extends Migration
{
    public function up()
    {
        Schema::table('awebsome_realestate_realty', function(Blueprint $table) {
            $table->string("status")->nullable()->change();
        });
    }

    public function down()
    {
        // do nothing...
    }
}
