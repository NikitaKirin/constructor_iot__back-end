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
        Schema::create('course_skill', function ( Blueprint $table ) {
            $table->foreignId('course_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('skill_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->primary(['course_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('course_skill');
    }
};
