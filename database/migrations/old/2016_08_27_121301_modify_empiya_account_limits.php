<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmpiyaAccountLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_account_limits', function (Blueprint $table) {
            $table->renameColumn('account_id', 'empiya_account_id');
			$table->renameColumn('account_limit_type_id', 'empiya_account_limit_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_account_limits', function (Blueprint $table) {
            //
        });
    }
}
