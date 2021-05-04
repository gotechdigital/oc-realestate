<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateAwebsomeRealestateRealty extends Migration
{
    public function up()
    {
        Schema::table('awebsome_realestate_realty', function($table) {
            $table->integer('views')->after('address')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('awebsome_realestate_realty', function($table) {
            $table->dropColumn('views');
        });
    }
}
