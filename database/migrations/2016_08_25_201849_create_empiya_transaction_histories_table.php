<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpiyaTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empiya_transaction_histories', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('transaction_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('is_debit');
			$table->decimal('initial_balance', 13, 4);
			$table->decimal('final_balance', 13, 4);
            $table->timestamps();
			$table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empiya_transaction_histories');
    }
}
