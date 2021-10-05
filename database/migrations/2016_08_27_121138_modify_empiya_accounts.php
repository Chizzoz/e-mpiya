<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmpiyaAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_accounts', function (Blueprint $table) {
            $table->renameColumn('account_type_id', 'empiya_account_type_id
');
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
