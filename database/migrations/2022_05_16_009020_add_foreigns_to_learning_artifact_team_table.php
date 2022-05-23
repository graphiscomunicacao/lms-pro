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
        Schema::table('learning_artifact_team', function (Blueprint $table) {
            $table
                ->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('learning_artifact_id')
                ->references('id')
                ->on('learning_artifacts')
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
        Schema::table('learning_artifact_team', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropForeign(['learning_artifact_id']);
        });
    }
};
