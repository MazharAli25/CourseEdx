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
        Schema::create('lecture_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->foreignId('courseId')->constrained('courses')->onDelete('cascade');
            $table->foreignId('sectionId')->constrained('course_sections')->onDelete('cascade');
            $table->foreignId('lectureId')->constrained('course_lectures')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->integer('watch_duration')->default(0);
            $table->timestamp('last_watched_at')->nullable();
            $table->timestamps(); // This creates created_at AND updated_at - CALL IT ONLY ONCE!

            // Prevent duplicate entries
            $table->unique(['userId', 'lectureId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_progress');
    }
};
