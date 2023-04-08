<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assembly_professional_trajectory', function (Blueprint $table) {
            $table->foreignId('course_assembly_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('professional_trajectory_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('course_assembly_level_digital_value')
                ->constrained('course_assembly_levels', 'digital_value')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assembly_professional_trajectory');
    }
};
