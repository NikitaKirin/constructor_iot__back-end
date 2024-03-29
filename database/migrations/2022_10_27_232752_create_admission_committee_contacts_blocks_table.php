<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('admission_committee_contacts_blocks', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->foreignId('institute_id')
                  ->constrained()
                  ->restrictOnDelete();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('admission_committee_contacts_blocks');
    }
};
