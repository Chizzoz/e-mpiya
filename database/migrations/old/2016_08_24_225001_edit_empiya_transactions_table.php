<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEmpiyaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('empiya_transactions', function($table) {
			$table->foreign('transaction_type_id')->references('id')->on('empiya_transaction_types');
		});
		Schema::table('empiya_transactions', function($table) {
			$table->foreign('transaction_status_id')->references('id')->on('empiya_transaction_statuses');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empiya_transactions');
    }
}
