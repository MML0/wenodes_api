<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
