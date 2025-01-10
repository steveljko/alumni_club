<?php

use App\Enums\Post\PostStatus;
use App\Enums\Post\PostType;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->enum('status', PostStatus::toArray())
                ->default(PostStatus::DRAFT->value);
            $table->enum('type', PostType::toArray())
                ->default(PostType::DEFAULT->value);
            $table->string('likes_count')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
