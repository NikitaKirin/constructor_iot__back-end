<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('video_id')->nullable()->constrained('attachments', 'id')->nullOnDelete();
            $table->foreignId('presentation_id')->nullable()->constrained('attachments', 'id')->nullOnDelete();
            $table->renameColumn('limit', 'seat_limit');
        });
    }

    public function down() {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['video_id', 'presentation_id']);
           $table->renameColumn('seat_limit', 'limit');
        });
    }
};
