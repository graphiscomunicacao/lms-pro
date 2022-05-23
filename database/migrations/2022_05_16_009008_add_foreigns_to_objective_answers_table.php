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
        Schema::table('objective_answers', function (Blueprint $table) {
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('objective_question_id')
                ->references('id')
                ->on('objective_questions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('objective_question_option_id')
                ->references('id')
                ->on('objective_question_options')
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
        Schema::table('objective_answers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['objective_question_id']);
            $table->dropForeign(['objective_question_option_id']);
        });
    }
};
