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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable(); // Add last_name column
            $table->string('bio')->nullable(); // Add bio column
            $table->enum('type', ['admin', 'editor', 'pro_member', 'team_member', 'user'])->default('user'); // Add user type with specified roles and default to user
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable(); // Add phone_verified_at column
            $table->string('password');
            $table->boolean('want_news')->default(false); // Add want_news column
            $table->boolean('want_pro_membership')->default(false); // Add want_pro_membership column
            $table->string('phone')->nullable(); // Add phone column
            $table->string('photo')->nullable(); // Added profile image URL
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Insert test users
        DB::table('users')->insert([
            [
                'name' => 'John',
                'last_name' => 'Doe',
                'bio' => 'A passionate artist.',
                'type' => 'user',
                'email' => 'a@a.a',
                'password' => bcrypt('Aa123456@'),
                'want_news' => true,
                'want_pro_membership' => false,
                'phone' => '09123456789',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane',
                'last_name' => 'Smith',
                'bio' => 'An experienced editor.',
                'type' => 'editor',
                'email' => 'jane@example.com',
                'password' => bcrypt('MyPassword@2'),
                'want_news' => false,
                'want_pro_membership' => true,
                'phone' => '09123456780',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice',
                'last_name' => 'Johnson',
                'bio' => 'A dedicated admin.',
                'type' => 'admin',
                'email' => 'alice@example.com',
                'password' => bcrypt('MyPassword@3'),
                'want_news' => true,
                'want_pro_membership' => false,
                'phone' => '09123456781',
                'photo' => null,
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
