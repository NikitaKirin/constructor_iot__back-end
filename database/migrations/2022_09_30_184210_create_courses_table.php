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
            $table->foreignId('video_id')->nullable()->constrained('attachments', 'id')->nullOnDelete();
            $table->foreignId('presentation_id')->nullable()->constrained('attachments', 'id')->nullOnDelete();
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
