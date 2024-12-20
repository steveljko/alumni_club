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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password_reset_token')
                ->after('password')
                ->unique()
                ->nullable();
            $table->string('password_reset_token_generated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['password_reset_token']);
            $table->dropColumn('password_reset_token');
            $table->dropColumn('password_reset_token_generated_at');
        });
    }
};
