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
        Schema::connection('users_gifts_database')->create('users_gifts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gift_id')->index();
            $table->foreignId('user_id')->index();

            $table->boolean('game')->index()->default(false);
            $table->boolean('premium')->index()->default(false);
            $table->integer('step')->index();
            $table->double('price')->nullable();

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
        Schema::connection('users_gifts_database')->dropIfExists('users_gifts');
    }
};
