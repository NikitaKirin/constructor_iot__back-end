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
    public function up() {
        Schema::create('professions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('headhunter_search_text')->nullable();
            $table->integer('vacancies_count')->nullable();
            $table->integer('area_vacancies_count')->nullable();
            $table->integer('maximal_salary')->nullable();
            $table->integer('minimal_salary')->nullable();
            $table->integer('median_salary')->nullable();
            $table->foreignId('photo_id')
                ->nullable()
                ->constrained('attachments', 'id')
                ->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('professions');
    }
};
