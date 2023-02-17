<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('profession_professional_trajectory', function (Blueprint $table) {
            $table->foreignId('profession_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('professional_trajectory_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->primary(['profession_id', 'professional_trajectory_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('profession_professional_trajectory');
    }
};
