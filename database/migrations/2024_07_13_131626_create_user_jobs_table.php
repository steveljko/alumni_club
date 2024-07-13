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
    Schema::create('user_jobs', function (Blueprint $table) {
      $table->id();
      $table->string('company_name');
      $table->string('position');
      $table->date('start_date');
      $table->date('end_date')->default(null);
      $table->text('desc');
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
    Schema::dropIfExists('user_jobs');
  }
};
