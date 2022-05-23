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
        Schema::table('category_learning_artifact', function (
            Blueprint $table
        ) {
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::table('category_learning_artifact', function (
            Blueprint $table
        ) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['learning_artifact_id']);
        });
    }
};
