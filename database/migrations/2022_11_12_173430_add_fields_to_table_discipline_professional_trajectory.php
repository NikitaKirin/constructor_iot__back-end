<?php

use App\Models\DisciplineLevel;
use Database\Seeders\DisciplineLevelSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('discipline_professional_trajectory', function ( Blueprint $table ) {
            if ( !DisciplineLevel::first()?->get() ) {
                \Illuminate\Support\Facades\Artisan::call('db:seed',
                    ['--class' => DisciplineLevelSeeder::class]);
            }
            $table->foreignId('discipline_level_digital_value')
                  ->default(DisciplineLevel::first()->id)
                  ->constrained('discipline_levels', 'digital_value')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
        });
    }

    public function down() {
        Schema::table('discipline_professional_trajectory', function ( Blueprint $table ) {
            $table->dropColumn('discipline_level_id');
        });
    }
};
