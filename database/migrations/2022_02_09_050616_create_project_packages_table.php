<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPackagesTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
    Schema::create('project_packages', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id')->index();
        $table->unsignedBigInteger('type_id')->index();
        $table->unsignedBigInteger('contactor_id')->index();
        $table->integer('contactor_type');
        $table->string('package_name');
        $table->string('package_number');;
        $table->string('package_duration');
        $table->date('package_start_date');
        $table->date('package_end_date');
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
    Schema::dropIfExists('project_packages');
}
}
