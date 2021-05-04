<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAwebsomeRealestateCategories extends Migration
{
    public function up()
    {
        Schema::table('awebsome_realestate_realty', function($table) {
            $table->string('address', 255)->after('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('awebsome_realestate_realty', function($table) {
            $table->dropColumn('address');
        });
    }
}
