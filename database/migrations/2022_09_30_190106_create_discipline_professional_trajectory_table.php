<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discipline_professional_trajectory', function (Blueprint $table) {
            $table->foreignId('discipline_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('professional_trajectory')
                ->constrained()
                ->cascadeOnDelete();
            $table->primary(['discipline_id', 'professional_trajectory']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discipline_professional_trajectory');
    }
};
