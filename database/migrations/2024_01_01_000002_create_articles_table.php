<?php
// database/migrations/2024_01_01_000002_create_articles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('content');
            $table->enum('category', [
                'nepal', 'australia', 'community', 'business',
                'sports', 'entertainment', 'opinion', 'culture'
            ]);
            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->enum('language', ['en', 'ne'])->default('en');
            $table->timestamps();

            // Indexes for performance
            $table->index(['category', 'status', 'published_at']);
            $table->index(['is_featured', 'status']);
            $table->index(['is_breaking', 'status']);
            if (config('database.default') !== 'sqlite') {
    $table->fullText(['title', 'content', 'summary']);
}
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
