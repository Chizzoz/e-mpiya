<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAccountsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transactions', function (Blueprint $table) {
			$table->integer('sender_account_id')->unsigned()->after('sender_id');
			$table->integer('receiver_account_id')->unsigned()->after('receiver_id');
        });
		
		Schema::table('empiya_transactions', function($table) {
			$table->foreign('sender_account_id')->references('id')->on('empiya_accounts');
			$table->foreign('receiver_account_id')->references('id')->on('empiya_accounts');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_transactions', function (Blueprint $table) {
            //
        });
    }
}
