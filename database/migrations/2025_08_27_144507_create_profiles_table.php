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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('profile_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('education')->nullable();
            $table->string('work')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
