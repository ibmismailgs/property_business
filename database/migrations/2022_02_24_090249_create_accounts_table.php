<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->index();
            $table->integer('admin_id')->nullable()->index(); //Auth Parent id
            $table->string('account_no');
            $table->integer('bank_id')->index();
            $table->string('branch_name');
            $table->double('initial_balance')->default(0);
            $table->double('balance')->default(0);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
