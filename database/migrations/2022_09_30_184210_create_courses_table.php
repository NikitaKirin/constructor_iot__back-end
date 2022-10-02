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
        Schema::create('courses', function ( Blueprint $table ) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('limit');
            $table->foreignId('discipline_id')
                  ->constrained('disciplines', 'id')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('partner_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('realization_id')
                  ->constrained()
                  ->restrictOnDelete();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
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
        Schema::dropIfExists('courses');
    }
};
