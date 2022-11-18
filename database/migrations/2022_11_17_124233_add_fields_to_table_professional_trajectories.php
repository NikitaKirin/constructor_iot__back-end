<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('professional_trajectories', function ( Blueprint $table ) {
            $table->integer('sum_discipline_levels_points')->default(0);
        });
    }

    public function down() {
        Schema::table('professional_trajectories', function ( Blueprint $table ) {
            $table->dropColumn('sum_discipline_levels_points');
        });
    }
};
