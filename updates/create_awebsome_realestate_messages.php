<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAwebsomeRealestateMessages extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_messages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->integer('realty_id');
            $table->text('message');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_messages');
    }
}
