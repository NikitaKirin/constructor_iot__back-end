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
        Schema::create('educational_direction_educational_module', function ( Blueprint $table ) {
            $table->foreignId('educational_direction_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('educational_module_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->primary(['educational_direction_id', 'educational_module_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('educational_direction_educational_module');
    }
};
