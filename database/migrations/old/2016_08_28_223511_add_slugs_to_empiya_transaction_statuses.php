<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugsToEmpiyaTransactionStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transaction_statuses', function (Blueprint $table) {
            $table->string('transaction_status_slug')->after('transaction_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_transaction_statuses', function (Blueprint $table) {
            //
        });
    }
}
