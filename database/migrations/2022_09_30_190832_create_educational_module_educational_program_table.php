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
        Schema::create('educational_module_educational_program', function ( Blueprint $table ) {
            $table->foreignId('educational_module_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('educational_program_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->primary(['educational_module_id', 'educational_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('educational_module_educational_program');
    }
};
