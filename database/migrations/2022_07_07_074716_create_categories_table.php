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
        Schema::connection('gifts_pgsql')->create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type')->default('daily')->index();
            $table->string('packages')->default('internet')->index();
            $table->integer('step')->default(1)->index();
            $table->integer('last_package_id')->nullable()->index();

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
        Schema::connection('gifts_pgsql')->dropIfExists('categories');
    }
};
