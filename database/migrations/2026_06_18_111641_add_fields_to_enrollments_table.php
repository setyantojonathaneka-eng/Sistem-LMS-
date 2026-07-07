<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('progress'); // hapus kolom lama
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active')->after('course_id');
            $table->timestamp('enrolled_at')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('enrolled_at');
            $table->float('progress_percentage')->default(0)->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['status', 'enrolled_at', 'completed_at', 'progress_percentage']);
            $table->unsignedTinyInteger('progress')->default(0);
        });
    }
};