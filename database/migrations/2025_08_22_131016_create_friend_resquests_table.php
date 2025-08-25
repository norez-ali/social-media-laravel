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
        Schema::create('friend_resquests', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('sender_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('receiver_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_resquests');
    }
};
