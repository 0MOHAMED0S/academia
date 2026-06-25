<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 191)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('instructors', function (Blueprint $table) {
            if (! Schema::hasColumn('instructors', 'job_title')) {
                $table->string('job_title')->nullable()->after('email');
            }

            if (! Schema::hasColumn('instructors', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('job_title');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'track_id')) {
                $table->foreignId('track_id')->nullable()->after('instructor_id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('courses', 'type')) {
                $table->string('type')->default('free')->after('slug');
            }

            if (! Schema::hasColumn('courses', 'roadmap')) {
                $table->longText('roadmap')->nullable()->after('description');
            }
        });

        Schema::table('lessons', function (Blueprint $table) {
            if (! Schema::hasColumn('lessons', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('video_path');
            }
        });

        Schema::table('course_user', function (Blueprint $table) {
            if (! Schema::hasColumn('course_user', 'payment_cash_id')) {
                $table->string('payment_cash_id')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('course_user', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_cash_id');
            }

            if (! Schema::hasColumn('course_user', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('payment_verified_at');
            }

            if (! Schema::hasColumn('course_user', 'grade')) {
                $table->unsignedTinyInteger('grade')->nullable()->after('completed_at');
            }
        });

        Schema::create('lesson_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('correct_option', 1);
            $table->timestamps();
        });

        Schema::create('lesson_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->unsignedTinyInteger('total')->default(5);
            $table->boolean('passed')->default(false);
            $table->timestamps();
            $table->unique(['lesson_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_attempts');
        Schema::dropIfExists('lesson_questions');

        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn(['payment_cash_id', 'payment_verified_at', 'completed_at', 'grade']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['track_id']);
            $table->dropColumn(['track_id', 'type', 'roadmap']);
        });

        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'profile_photo']);
        });

        Schema::dropIfExists('tracks');
    }
};
