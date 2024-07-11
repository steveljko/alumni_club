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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('email');
            $table->boolean('email_visible')->default(false);
            $table->string('phone_number');
            $table->boolean('phone_number_visible')->default(false);
            $table->string('uni_start_year');
            $table->string('uni_finish_year');
            $table->text('bio');
            $table->foreignId('user_id')->constrained();
            $table->integer('changed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
