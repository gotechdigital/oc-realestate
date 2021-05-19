<?php namespace Awebsome\Realestate\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAwebsomeRealestateRealtyFeature extends Migration
{
    public function up()
    {
        Schema::create('awebsome_realestate_realty_feature', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('realty_id');
            $table->integer('feature_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('awebsome_realestate_realty_feature');
    }
}
