<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMavitmEstateRealty extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_realty', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->smallInteger('status')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('excerpt', 255)->nullable();
            $table->text('description')->nullable();
            $table->double('price', 10, 2);
            $table->smallInteger('published');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_realty');
    }
}