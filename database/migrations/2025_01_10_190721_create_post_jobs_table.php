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
        Schema::create('post_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->text('description')->nullable();
            $table->string('company_name');
            $table->string('company_website_url');
            $table->string('company_address');
            $table->string('company_city');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->string('job_page_url');
            $table->foreignId('post_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_jobs');
    }
};
