<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpiyaCurrencyIdToEmpiyaAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('empiya_currency_id')->after('empiya_account_type_id');
            $table->foreign('empiya_currency_id')->references('id')->on('empiya_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_accounts', function (Blueprint $table) {
            //
        });
    }
}
