<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id', 191)->nullable()->unique()->after('email');
            }
        });

        Schema::table('instructors', function (Blueprint $table) {
            if (! Schema::hasColumn('instructors', 'google_id')) {
                $table->string('google_id', 191)->nullable()->unique()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
        });

        Schema::table('instructors', function (Blueprint $table) {
            if (Schema::hasColumn('instructors', 'google_id')) {
                $table->dropColumn('google_id');
            }
        });
    }
};
