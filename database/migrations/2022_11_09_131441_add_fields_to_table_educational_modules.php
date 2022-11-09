<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('educational_modules', function ( Blueprint $table ) {
            $table->boolean('is_spec')->default(false);
        });
    }

    public function down() {
        Schema::table('educational_modules', function ( Blueprint $table ) {
            $table->dropColumn('is_spec');
        });
    }
};
