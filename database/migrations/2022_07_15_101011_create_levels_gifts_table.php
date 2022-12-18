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
        Schema::connection('levels_pgsql')->create('levels_gifts', function (Blueprint $table) {
            $table->id();

            $table->jsonb('name');
            $table->string('type')->index()->default('internet');

            $table->integer('package_id')->nullable();

            $table->unsignedInteger('level_id')->index();
            $table->boolean('published')->default(false)->index();
            $table->integer('count')->default(0)->index();
            $table->string('image', 500)->nullable();
            $table->integer('position')->default(0);
            $table->integer('count_draft')->default(0)->index();
            $table->integer('probability')->default(0)->index();

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
        Schema::connection('levels_pgsql')->dropIfExists('levels_gifts');
    }
};
