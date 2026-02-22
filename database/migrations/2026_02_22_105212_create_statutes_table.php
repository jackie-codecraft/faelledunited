<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statutes', function (Blueprint $table) {
            $table->id();
            $table->longText('content_da');
            $table->longText('content_en');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statutes');
    }
};
