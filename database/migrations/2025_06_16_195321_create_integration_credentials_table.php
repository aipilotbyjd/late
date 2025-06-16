<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('integration_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('integration_id')->constrained()->onDelete('cascade');
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('api_key')->nullable();
            $table->string('webhook_url')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_credentials');
    }
};
