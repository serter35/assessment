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
        Schema::create('recipient_sent_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipient_id')->unique()->constrained();
            $table->uuid('message_id')->index();
            $table->timestamp('sent_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_sent_messages');
    }
};
