<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmpiyaTransactionHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transaction_histories', function (Blueprint $table) {
            $table->renameColumn('transaction_id', 'empiya_transaction_id');
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
