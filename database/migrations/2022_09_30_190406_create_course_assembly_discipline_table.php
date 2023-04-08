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
        Schema::create('course_assembly_discipline', function (Blueprint $table) {
            $table->foreignId('course_assembly_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('discipline_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assembly_discipline');
    }
};
