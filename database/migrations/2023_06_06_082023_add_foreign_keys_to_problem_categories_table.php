<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problem_categories', function (Blueprint $table) {
            $table->foreign(['unit_id'], 'problem_categories_ibfk_1')->references(['id'])->on('units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problem_categories', function (Blueprint $table) {
            $table->dropForeign('problem_categories_ibfk_1');
        });
    }
};
