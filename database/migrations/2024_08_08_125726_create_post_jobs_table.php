<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->text('description');
            $table->string('company_name');
            $table->string('company_city');
            $table->timestamp('opening_start');
            $table->timestamp('opening_end')->nullable();
            $table->string('job_page_url');
            $table->foreignId('post_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();

            $table->index(['company_name', 'company_city']);
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
