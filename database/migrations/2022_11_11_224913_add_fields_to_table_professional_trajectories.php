<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('professional_trajectories', function ( Blueprint $table ) {
            $table->string('slug', 15)
                  ->default('slug');
        });
    }

    public function down() {
        Schema::table('professional_trajectories', function ( Blueprint $table ) {
            $table->dropColumn('slug');
        });
    }
};
