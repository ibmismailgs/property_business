<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubContactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_contactors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contactor_id')->index();
            $table->string('subcontactor_name');
            $table->string('subcontactor_email');
            $table->string('subcontactor_phone');
            $table->string('subcontactor_address');
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
        Schema::dropIfExists('sub_contactors');
    }
}
