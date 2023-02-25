<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('professions', function (Blueprint $table) {
            $table->integer('area_vacancies_count')->nullable();
        });
    }

    public function down() {
        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn('area_vacancies_count');
        });
    }
};
