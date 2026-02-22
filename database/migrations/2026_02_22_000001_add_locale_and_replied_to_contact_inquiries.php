<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->string('locale', 5)->default('da')->after('message');
        });

        // Extend the status enum to include 'replied'
        DB::statement("ALTER TABLE contact_inquiries MODIFY COLUMN status ENUM('new', 'in_progress', 'resolved', 'replied') NOT NULL DEFAULT 'new'");
    }

    public function down(): void
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->dropColumn('locale');
        });

        DB::statement("ALTER TABLE contact_inquiries MODIFY COLUMN status ENUM('new', 'in_progress', 'resolved') NOT NULL DEFAULT 'new'");
    }
};
