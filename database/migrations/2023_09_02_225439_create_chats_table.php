<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table-> foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->text('response')->nullable();
            $table->json('response_metadata')->nullable();
            $table->string('image')->nullable();
            $table->string('disease')->nullable();
            $table->string('probability')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
