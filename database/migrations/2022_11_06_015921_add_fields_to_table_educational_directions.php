<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('educational_directions', function ( Blueprint $table ) {
            $table->jsonb('passing_scores')
                  ->default(json_encode([
                      [
                          'year'          => null,
                          'passing_score' => null,
                      ],
                  ]));
            $table->string('training_period')->default('4 года');
            $table->integer('budget_places')->default('100');
        });
    }

    public function down() {
        Schema::table('educational_directions', function ( Blueprint $table ) {
            $table->dropColumn('passing_scores');
            $table->dropColumn('training_period');
            $table->dropColumn('budget_places');
        });
    }
};
