<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->index();
            $table->integer('admin_id')->nullable()->index();
            $table->string('date');
            $table->integer('account_id')->index();
            $table->double('amount')->default(0);
            $table->double('post_balance')->default(0);
            $table->integer('purpose')->index()->comment('0 is initial balance, 1 is Withdraw, 2 is for Deposit, 3 for Received Payment,4 is Given Payment');
            $table->string('cheque_number')->nullable();
            $table->integer('type')->nullable()->comment('1 for Cheque, 2 for balance transfer');
            $table->string('balance_transfer_info')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
