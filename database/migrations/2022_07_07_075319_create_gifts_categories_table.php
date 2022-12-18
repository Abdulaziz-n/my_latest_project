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
        Schema::connection('gifts_pgsql')->create('gifts_categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('gift_id')->index();
            $table->unsignedInteger('category_id')->index();

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
        Schema::connection('gifts_pgsql')->dropIfExists('gifts_categories');
    }
};
