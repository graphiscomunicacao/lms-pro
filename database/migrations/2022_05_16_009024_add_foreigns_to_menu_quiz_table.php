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
        Schema::table('menu_quiz', function (Blueprint $table) {
            $table
                ->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('menu_id')
                ->references('id')
                ->on('menus')
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
        Schema::table('menu_quiz', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropForeign(['menu_id']);
        });
    }
};
