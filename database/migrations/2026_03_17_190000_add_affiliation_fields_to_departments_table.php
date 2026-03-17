<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('affiliation_name')->nullable()->after('hero_image');
            $table->string('affiliation_logo')->nullable()->after('affiliation_name');
            $table->string('affiliation_url')->nullable()->after('affiliation_logo');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['affiliation_name', 'affiliation_logo', 'affiliation_url']);
        });
    }
};
