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
        Schema::create('employees', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('audience')->nullable();
            $table->string('additional_information')->nullable();
            $table->string('vk_profile')->nullable();
            $table->foreignId('photo_id')->nullable()
                  ->constrained('attachments', 'id')
                  ->nullOnDelete();
            $table->foreignId('position_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()
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
        Schema::dropIfExists('employees');
    }
};
