<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountIdToTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transaction_histories', function (Blueprint $table) {
            $table->integer('empiya_account_id')->unsigned()->after('user_id');
        });
		
		Schema::table('empiya_transaction_histories', function($table) {
			$table->foreign('empiya_account_id')->references('id')->on('empiya_accounts');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_transaction_histories', function (Blueprint $table) {
            //
        });
    }
}
