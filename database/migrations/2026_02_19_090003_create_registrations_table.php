<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('age_group_id')->constrained();
            $table->string('player_name');
            $table->date('date_of_birth');
            $table->string('current_club_experience')->nullable();
            $table->string('parent_name');
            $table->string('parent_email');
            $table->string('address');
            $table->string('phone');
            $table->text('additional_info')->nullable();
            $table->boolean('gdpr_consent')->default(false);
            $table->boolean('photo_consent')->default(false);
            $table->enum('status', ['new', 'contacted', 'registered', 'rejected'])->default('new');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('registrations'); }
};
