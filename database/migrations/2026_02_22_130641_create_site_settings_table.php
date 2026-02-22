<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Contact
            $table->string('contact_email')->default('info@faelledunited.dk');
            $table->foreignId('default_inquiry_assignee_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Registration
            $table->boolean('registration_open')->default(true);
            $table->text('registration_closed_message_da')->nullable();
            $table->text('registration_closed_message_en')->nullable();

            // Social
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
