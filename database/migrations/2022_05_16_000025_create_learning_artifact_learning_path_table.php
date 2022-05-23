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
        Schema::create('learning_artifact_learning_path', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('learning_artifact_id');
            $table->unsignedBigInteger('learning_path_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_artifact_learning_path');
    }
};