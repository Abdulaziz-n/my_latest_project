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
        Schema::connection('information_pgsql')->create('guides', function (Blueprint $table) {
            $table->id();

            $table->jsonb('title');
            $table->jsonb('body')->nullable();
            $table->string('image')->nullable();
            $table->integer('position')->default(0);

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
        Schema::connection('information_pgsql')->dropIfExists('guides');
    }
};
