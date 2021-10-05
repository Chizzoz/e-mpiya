<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpiyaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empiya_transactions', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('provider_id')->unsigned();
			$table->string('reference_number');
			$table->integer('related_transaction_id')->unsigned();
			$table->integer('sender_id')->unsigned();
			$table->integer('receiver_id')->unsigned();
			$table->float('amount');
			$table->float('transaction_fee')->default(0.00);
			$table->integer('transaction_type_id')->unsigned();
			$table->string('description');
			$table->integer('transaction_status_id')->unsigned();
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
        Schema::drop('empiya_transactions');
    }
}
