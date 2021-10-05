<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpiyaAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empiya_accounts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->bigInteger('account_number');
			$table->integer('account_type_id')->unsigned();
            $table->timestamps();
			$table->engine = 'InnoDB';
        });
		
		Schema::table('empiya_accounts', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('account_type_id')->references('id')->on('empiya_account_types');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empiya_accounts');
    }
}
