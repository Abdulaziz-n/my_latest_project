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
        Schema::connection('information_pgsql')->create('socials', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('type');
            $table->integer('position')->default(1);
            $table->string('url');

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
        Schema::connection('information_pgsql')->dropIfExists('socials');
    }
};
