<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAwebsomeRealestateTags extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_tags');
    }
}
