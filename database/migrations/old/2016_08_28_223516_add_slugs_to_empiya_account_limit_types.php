<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugsToEmpiyaAccountLimitTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empiya_account_limit_types', function (Blueprint $table) {
            $table->string('account_limit_type_slug')->after('account_limit_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empiya_account_limit_types', function (Blueprint $table) {
            //
        });
    }
}
