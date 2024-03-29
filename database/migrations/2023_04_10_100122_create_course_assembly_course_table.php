<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_assembly_course', function (Blueprint $table) {
            $table->foreignId('course_assembly_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_assembly_course');
    }
};
