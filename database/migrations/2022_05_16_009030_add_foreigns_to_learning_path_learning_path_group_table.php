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
        Schema::table('learning_path_learning_path_group', function (
            Blueprint $table
        ) {
            $table
                ->foreign('learning_path_id')
                ->references('id')
                ->on('learning_paths')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('learning_path_group_id')
                ->references('id')
                ->on('learning_path_groups')
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
        Schema::table('learning_path_learning_path_group', function (
            Blueprint $table
        ) {
            $table->dropForeign(['learning_path_id']);
            $table->dropForeign(['learning_path_group_id']);
        });
    }
};
