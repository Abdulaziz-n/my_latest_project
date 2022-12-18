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
        Schema::create('answers_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('organization_id')->index();
            $table->string('answer_id')->index();
            $table->string('question_id')->nullable();
            $table->string('survey_id')->nullable();
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
        Schema::dropIfExists('answers_users');
    }
};
