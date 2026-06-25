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
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                if (! Schema::hasColumn('admins', 'name')) {
                    $table->string('name')->default('Admin')->after('id');
                }

                if (! Schema::hasColumn('admins', 'email')) {
                    $table->string('email', 191)->nullable()->after('name');
                }

                if (! Schema::hasColumn('admins', 'password')) {
                    $table->string('password')->nullable()->after('email');
                }
            });

            return;
        }

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Admin');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
