<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('educational_directions', function (Blueprint $table) {
            $table->string('page_link')
                ->default('https://priem-rtf.urfu.ru');
        });
    }

    public function down()
    {
        Schema::table('educational_directions', function (Blueprint $table) {
            $table->dropColumn('page_link');
        });
    }
};