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
        Schema::create('learning_path_learning_path_group', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('learning_path_id');
            $table->unsignedBigInteger('learning_path_group_id');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_path_learning_path_group');
    }
};
