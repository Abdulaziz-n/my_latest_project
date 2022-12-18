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
        Schema::connection('gifts_pgsql')->create('offers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('offer_id');
            $table->jsonb('types');

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
        Schema::connection('gifts_pgsql')->dropIfExists('offers');
    }
};
