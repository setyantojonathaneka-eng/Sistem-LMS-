<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->unique(['user_id', 'lesson_id']);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn('lesson_id');
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'lesson_id']);
            $table->dropColumn(['user_id', 'lesson_id', 'is_completed', 'completed_at']);
        });
    }
};
