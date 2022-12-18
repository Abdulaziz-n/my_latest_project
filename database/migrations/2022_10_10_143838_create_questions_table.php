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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->jsonb('name');
            $table->jsonb('hint')->nullable();
            $table->integer('survey_id')->index();
            $table->integer('award_coins');
            $table->integer('position')->nullable();
            $table->integer('input_type_id');
            $table->boolean('is_draft');
            $table->boolean('is_multiple');
            $table->boolean('is_required');
            $table->integer('timer');

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
        Schema::dropIfExists('questions');
    }
};
