<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('discipline_levels', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('title');
            $table->integer('digital_value')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('discipline_levels');
    }
};