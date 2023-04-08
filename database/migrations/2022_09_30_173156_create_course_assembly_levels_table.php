<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('course_assembly_levels', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('title');
            $table->smallInteger('digital_value')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('course_assembly_levels');
    }
};
