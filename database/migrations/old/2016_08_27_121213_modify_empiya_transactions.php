<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmpiyaTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transactions', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'empiya_provider_id');
            $table->renameColumn('transaction_type_id', 'empiya_transaction_type_id');
            $table->renameColumn('transaction_status_id', 'empiya_transaction_status_id');
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
