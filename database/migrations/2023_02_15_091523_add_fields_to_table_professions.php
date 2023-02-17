<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('professions', function (Blueprint $table) {
            $table->string('headHunter_title')->default('Developer');
            $table->integer('vacancies_count')->nullable();
            $table->integer('maximal_salary')->nullable();
            $table->integer('minimal_salary')->nullable();
            $table->integer('median_salary')->nullable();
            $table->foreignId('photo_id')
                ->nullable()
                ->constrained('attachments', 'id')
                ->nullOnDelete();
        });
    }

    public function down() {
        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn([
                'headHunter_title',
                'vacancies_count',
                'maximal_salary',
                'minimal_salary',
                'median_salary',
                'photo_id',
            ]);
        });
    }
};
