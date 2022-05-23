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
        Schema::table('job_menu', function (Blueprint $table) {
            $table
                ->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::table('job_menu', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropForeign(['menu_id']);
        });
    }
};
