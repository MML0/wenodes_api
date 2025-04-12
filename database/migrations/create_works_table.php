<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title_fa');
            $table->string('title_en');
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->string('cover_image')->nullable();  // path to image
            // later add galery photos
            $table->timestamps();
        });

        // Insert a test work
        DB::table('works')->insert([
            [
                'title_fa' => 'کار آزمایشی',
                'title_en' => 'Test Work',
                'description_fa' => 'این یک توضیح برای کار آزمایشی است.',
                'description_en' => 'This is a description for the test work.',
                'cover_image' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_fa' => 'کار دوم',
                'title_en' => 'Second Work',
                'description_fa' => 'این یک توضیح برای کار دوم است.',
                'description_en' => 'This is a description for the second work.',
                'cover_image' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_fa' => 'کار سوم',
                'title_en' => 'Third Work',
                'description_fa' => 'این یک توضیح برای کار سوم است.',
                'description_en' => 'This is a description for the third work.',
                'cover_image' => 'https://via.placeholder.com/150', // Real online placeholder photo
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
