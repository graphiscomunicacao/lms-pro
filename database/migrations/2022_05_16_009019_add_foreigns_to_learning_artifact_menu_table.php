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
        Schema::table('learning_artifact_menu', function (Blueprint $table) {
            $table
                ->foreign('learning_artifact_id')
                ->references('id')
                ->on('learning_artifacts')
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
        Schema::table('learning_artifact_menu', function (Blueprint $table) {
            $table->dropForeign(['learning_artifact_id']);
            $table->dropForeign(['menu_id']);
        });
    }
};
