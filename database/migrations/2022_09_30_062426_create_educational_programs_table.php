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
        Schema::create('educational_programs', function ( Blueprint $table ) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('educational_direction');
            $table->string('page_link')->default('https://priem-rtf.urfu.ru');
            $table->jsonb('passing_scores')
                ->default(json_encode([
                    [
                        'year'          => null,
                        'passing_score' => null,
                    ],
                ]));
            $table->string('training_period');
            $table->smallInteger('budget_places');
            $table->foreignId('institute_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('educational_programs');
    }
};
