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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // links to users table
            $table->string('role');  // Example: director, artist, tech_guy
            // $table->enum('role', ['director', 'artist', 'programmer']);  // Example roles
            $table->string('profile_image_url')->nullable(); // Added profile image URL

            $table->string('name_fa')->nullable();  // Persian name
            $table->string('name_en')->nullable();  // English name
            $table->text('bio_fa')->nullable();     // Persian bio
            $table->text('bio_en')->nullable();     // English bio

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
