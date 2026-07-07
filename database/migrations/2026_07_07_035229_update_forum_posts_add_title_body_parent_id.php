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
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('course_id');
            $table->text('body')->nullable()->after('title');
            $table->foreignId('parent_id')->nullable()->constrained('forum_posts')->cascadeOnDelete()->after('body');
            $table->dropColumn('content');
        });
    }

    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->text('content');
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['title', 'body', 'parent_id']);
        });
    }
};
