<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('board_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_da');
            $table->string('role_en');
            $table->text('bio_da')->nullable();
            $table->text('bio_en')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('board_members'); }
};
