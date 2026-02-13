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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacherId')->constrained('users');
            $table->foreignId('categoryId')->constrained('categories');
            $table->foreignId('subcategoryId')->constrained('sub_categories');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('language');
            $table->string('thumbnail');
            $table->enum('level',['basic', 'intermediate', 'advanced' ,'allLevels']);
            $table->enum('status',['draft', 'pending', 'rejected' ,'published']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
