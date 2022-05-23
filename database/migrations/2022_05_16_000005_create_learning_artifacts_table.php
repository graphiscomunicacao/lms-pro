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
        Schema::create('learning_artifacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('type', [
                'audio',
                'document',
                'interactive',
                'image',
                'video',
                'externo',
            ]);
            $table->decimal('size');
            $table->string('path');
            $table->text('description')->nullable();
            $table->boolean('external');
            $table->string('url')->nullable();
            $table->string('cover_path')->nullable();
            $table->integer('experience_amount');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_artifacts');
    }
};
