<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileBankingIdToPayoutSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payout_settings', function (Blueprint $table) {
            $table->integer('mobile_banking_id')->after('type')->nullable();
            $table->string('mobile_banking_number')->after('mobile_banking_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payout_settings', function (Blueprint $table) {
            $table->dropColumn('mobile_banking_id');
            $table->dropColumn('mobile_banking_number');
        });
    }
}
