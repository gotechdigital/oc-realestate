<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMavitmEstateFeatures extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_features', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_features');
    }
}
