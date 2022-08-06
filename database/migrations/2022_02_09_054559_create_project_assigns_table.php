<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAssignsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
    Schema::create('project_assigns', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id')->index();
        $table->unsignedBigInteger('employee_id')->index();
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
    Schema::dropIfExists('project_assigns');
}
}
