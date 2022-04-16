<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEmpiyaTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('empiya_transaction_histories', function($table) {
			$table->foreign('transaction_id')->references('id')->on('empiya_transactions');
		});
		Schema::table('empiya_transaction_histories', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empiya_transaction_histories');
    }
}
