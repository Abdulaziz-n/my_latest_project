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
        Schema::connection('levels_pgsql')->create('levels_scores', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('level_id')->index();
            $table->integer('score')->default(0);
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
        Schema::connection('levels_pgsql')->dropIfExists('levels_scores');
    }
};
