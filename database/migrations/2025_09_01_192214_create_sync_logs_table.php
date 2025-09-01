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
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform'); // linkedin, naukri, gulftalent, indeed
            $table->enum('status', ['pending', 'processing', 'success', 'failed', 'manual_required'])->default('pending');
            $table->text('sync_method')->nullable(); // automation, email, manual
            $table->json('request_data')->nullable(); // Data sent to n8n
            $table->json('response_data')->nullable(); // Response from n8n/bot
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('execution_time')->nullable(); // in seconds
            $table->json('bot_logs')->nullable(); // Browser bot execution logs
            $table->timestamps();

            $table->index(['platform', 'status']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
