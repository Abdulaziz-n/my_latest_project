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
        Schema::connection('gifts_pgsql')->create('gifts', function (Blueprint $table) {
            $table->id();

            $table->jsonb('name');
            $table->integer('package_id')->nullable()->index();
            $table->boolean('published')->default(false)->index();
            $table->boolean('first_prize')->default(false)->index();
            $table->boolean('super_prize')->default(false)->index();

            $table->string('type')->default('internet')->index();
            $table->boolean('premium')->index()->default(false);
            $table->string('sticker_id')->nullable();
            $table->integer('values')->default(0)->index();

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
        Schema::connection('gifts_pgsql')->dropIfExists('gifts');
    }
};
