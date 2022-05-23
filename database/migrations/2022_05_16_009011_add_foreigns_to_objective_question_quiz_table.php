<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objective_question_quiz', function (Blueprint $table) {
            $table
                ->foreign('objective_question_id')
                ->references('id')
                ->on('objective_questions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objective_question_quiz', function (Blueprint $table) {
            $table->dropForeign(['objective_question_id']);
            $table->dropForeign(['quiz_id']);
        });
    }
};
