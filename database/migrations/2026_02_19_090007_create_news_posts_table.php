<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title_da');
            $table->string('title_en');
            $table->text('excerpt_da')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('body_da');
            $table->longText('body_en');
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('news_posts'); }
};
