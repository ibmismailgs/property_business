<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectComponentDetailsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
    Schema::create('project_component_details', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('component_id')->index();
        $table->unsignedBigInteger('project_id')->index();
        $table->double('gob');
        $table->double('others_rpa');
        $table->double('dpa');
        $table->double('total');
        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down()
{
    Schema::dropIfExists('project_component_details');
}
}
