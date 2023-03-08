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
        Schema::create('discipline_professional_trajectory', function (Blueprint $table) {
            $table->foreignId('discipline_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('professional_trajectory_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('discipline_level_digital_value')
                ->constrained('discipline_levels', 'digital_value')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->primary(['discipline_id', 'professional_trajectory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discipline_professional_trajectory');
    }
};
