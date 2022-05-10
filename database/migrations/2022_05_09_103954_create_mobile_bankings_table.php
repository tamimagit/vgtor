<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileBankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_bankings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_no');
            $table->text('message');
            $table->string('image', 100);
            $table->integer('country_id');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_bankings');
    }
}
