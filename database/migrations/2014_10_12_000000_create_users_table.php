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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('total_experience')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->foreignId('role_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('job_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('manager_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('current_team_id')->nullable();
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
        Schema::dropIfExists('users');
    }
};
