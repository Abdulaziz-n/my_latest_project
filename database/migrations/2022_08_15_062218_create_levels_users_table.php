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
        Schema::connection('levels_users_database')->create('levels_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('level_gift_id')->index();
            $table->unsignedInteger('level_id')->index();

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
        Schema::connection('levels_users_database')->dropIfExists('levels_users');
    }
};
