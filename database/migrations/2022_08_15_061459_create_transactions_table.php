<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('transactions_database')->create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id')->index();
            $table->bigInteger('scores')->default(0);
            $table->unsignedInteger('level_id')->index();
            $table->integer('step')->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('transactions_database')->dropIfExists('transactions');
    }
};
