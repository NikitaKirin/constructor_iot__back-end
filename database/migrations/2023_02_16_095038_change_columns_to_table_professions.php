<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn('professional_trajectory_id');
        });
    }

    public function down() {
        Schema::table('professions', function (Blueprint $table) {
            //
        });
    }
};
