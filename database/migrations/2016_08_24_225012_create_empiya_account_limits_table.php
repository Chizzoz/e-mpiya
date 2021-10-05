<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpiyaAccountLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empiya_account_limits', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->integer('account_limit_type_id')->unsigned();
			$table->float('account_limit');
            $table->timestamps();
        });
		
		Schema::table('empiya_account_limits', function($table) {
			$table->foreign('account_id')->references('id')->on('empiya_accounts');
			$table->foreign('account_limit_type_id')->references('id')->on('empiya_account_limit_types');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empiya_account_limits');
    }
}
