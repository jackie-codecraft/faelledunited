<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('age_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('label_da');
            $table->string('label_en');
            $table->integer('birth_year')->nullable();
            $table->enum('gender', ['boys', 'girls', 'mixed'])->default('mixed');
            $table->text('description_da')->nullable();
            $table->text('description_en')->nullable();
            $table->json('training_schedule')->nullable();
            $table->json('coach_info')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('age_groups'); }
};
