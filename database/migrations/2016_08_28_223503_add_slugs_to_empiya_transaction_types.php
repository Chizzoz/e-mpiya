<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugsToEmpiyaTransactionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_transaction_types', function (Blueprint $table) {
            $table->string('transaction_type_slug')->after('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_transaction_types', function (Blueprint $table) {
            //
        });
    }
}
