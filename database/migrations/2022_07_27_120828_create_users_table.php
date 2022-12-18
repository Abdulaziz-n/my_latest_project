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
        Schema::connection('users_pgsql')->create('users', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('phone');
            $table->integer('verify_code')->nullable();

            $table->boolean('verified')->default(false);
            $table->boolean('stop')->default(false);
            $table->boolean('business')->default(0);

            $table->boolean('first_prize')->default(false);
            $table->boolean('prize')->default(false);

            $table->string('language')->default('uz');
            $table->string('company')->default('uzmobile')->index();

            $table->bigInteger('subscriber_id')->nullable();
            $table->bigInteger('personal_accountCustomer_id')->nullable();
            $table->bigInteger('rate_plan_id')->nullable();

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
        Schema::connection('users_pgsql')->dropIfExists('users');
    }
};
