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
        Schema::create('reviews', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('author');
            $table->text('text');
            $table->string('additional_information');
            $table->boolean('hidden')
                  ->default(false);
            $table->foreignId('photo_id')
                  ->nullable()
                  ->constrained('attachments', 'id')
                  ->nullOnDelete();
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
        Schema::dropIfExists('reviews');
    }
};
