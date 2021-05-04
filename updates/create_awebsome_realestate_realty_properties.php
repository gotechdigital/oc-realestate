<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMavitmEstateRealtyProperties extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_realty_properties', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('realty_id')->unsigned()->nullable()->index();
            $table->string('name', 255);
            $table->string('value', 255);
            $table->string('iconcss', 255)->nullable();
            $table->integer('sort_order')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_realty_properties');
    }
}
