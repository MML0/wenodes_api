<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade

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

        // Insert test artist data
        DB::table('team_members')->insert([
            [
                'user_id' => 1, // Assuming user ID 1 exists
                'role' => 'artist',
                'profile_image_url' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'name_fa' => 'هنرمند اول',
                'name_en' => 'First Artist',
                'bio_fa' => 'این هنرمند در زمینه هنرهای تجسمی فعالیت می‌کند.',
                'bio_en' => 'This artist works in the field of visual arts.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Assuming user ID 2 exists
                'role' => 'artist',
                'profile_image_url' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'name_fa' => 'هنرمند دوم',
                'name_en' => 'Second Artist',
                'bio_fa' => 'این هنرمند در زمینه نقاشی فعالیت می‌کند.',
                'bio_en' => 'This artist specializes in painting.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Assuming user ID 3 exists
                'role' => 'photographer',
                'profile_image_url' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'name_fa' => 'عکاس اول',
                'name_en' => 'First Photographer',
                'bio_fa' => 'این عکاس در زمینه عکاسی پرتره فعالیت می‌کند.',
                'bio_en' => 'This photographer specializes in portrait photography.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
