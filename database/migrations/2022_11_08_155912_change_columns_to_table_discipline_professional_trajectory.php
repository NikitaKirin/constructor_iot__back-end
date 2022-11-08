<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('discipline_professional_trajectory', function ( Blueprint $table ) {
            $table->renameColumn('professional_trajectory', 'professional_trajectory_id');
        });
    }

    public function down() {
        Schema::table('discipline_professional_trajectory', function ( Blueprint $table ) {
            //
        });
    }
};
