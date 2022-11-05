<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('social_networks_blocks', function ( Blueprint $table ) {
            $table->increments('id');
            $table->jsonb('data')
                  ->default(json_encode([
                      "Telegram"  => [
                          "url"  => "https://web.telegram.org",
                          'icon' => asset('storage/img/icons/social_networks/telegram-icon.svg'),
                      ],
                      "ВКонтакте" => [
                          "url"  => "https://vk.com",
                          'icon' => asset('storage/img/icons/social_networks/vk-icon.svg'),
                      ],
                  ]));
            $table->foreignId('institute_id')
                  ->constrained()
                  ->restrictOnDelete();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('social_networks_blocks');
    }
};
