<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAwebsomeRealestateRealtyTag extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_realty_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('realty_id');
            $table->integer('tag_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_realty_tag');
    }
}
