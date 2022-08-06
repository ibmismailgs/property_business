<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_inventories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('category_id')->index();
        $table->unsignedBigInteger('subcategory_id')->index();
        $table->unsignedBigInteger('group_id')->index();
        $table->unsignedBigInteger('item_id')->index();
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
        Schema::dropIfExists('item_inventories');
    }
}
