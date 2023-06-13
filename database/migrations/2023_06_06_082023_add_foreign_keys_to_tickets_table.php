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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign(['priority_id'], 'tickets_ibfk_1')->references(['id'])->on('priorities')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['unit_id'], 'tickets_ibfk_2')->references(['id'])->on('units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['owner_id'], 'tickets_ibfk_3')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['problem_category_id'], 'tickets_ibfk_4')->references(['id'])->on('problem_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['responsible_id'], 'tickets_ibfk_5')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['ticket_statuses_id'], 'tickets_ibfk_6')->references(['id'])->on('ticket_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_ibfk_1');
            $table->dropForeign('tickets_ibfk_2');
            $table->dropForeign('tickets_ibfk_3');
            $table->dropForeign('tickets_ibfk_4');
            $table->dropForeign('tickets_ibfk_5');
            $table->dropForeign('tickets_ibfk_6');
        });
    }
};
