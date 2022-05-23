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
        Schema::create('learning_path_group_results', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('submited_at');
            $table->integer('score');
            $table->unsignedBigInteger('learning_path_group_id');

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
        Schema::dropIfExists('learning_path_group_results');
    }
};
