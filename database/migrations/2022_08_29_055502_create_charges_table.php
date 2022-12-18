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
        Schema::connection('charges_database')->create('charges', function (Blueprint $table) {
            $table->id();

            $table->integer('attempt');
            $table->dateTime('charged_at');
            $table->date('date')->index();
            $table->timestamp('created_at')->index();
            $table->timestamp('last_attempt')->index();
            $table->integer('status')->default(false)->index();
            $table->integer('tariff')->index();
            $table->integer('user_id')->index();
            $table->boolean('stop')->default(false);
            $table->boolean('subscribe')->default(false);

            $table->bigInteger('phone')->nullable()->index();
            $table->double('price')->nullable()->index();
            $table->uuid('uuid')->index();

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
        Schema::connection('charges_database')->dropIfExists('charges');
    }
};
