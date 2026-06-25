<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            if (! Schema::hasColumn('instructors', 'name')) {
                $table->string('name')->after('id');
            }

            if (! Schema::hasColumn('instructors', 'email')) {
                $table->string('email', 191)->unique()->after('name');
            }

            if (! Schema::hasColumn('instructors', 'password')) {
                $table->string('password')->after('email');
            }

            if (! Schema::hasColumn('instructors', 'bio')) {
                $table->text('bio')->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn(['bio', 'password', 'email', 'name']);
        });
    }
};
