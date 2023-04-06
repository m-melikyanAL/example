<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_assets', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('extension', 50);
            $table->unsignedTinyInteger('type')->index();
            $table->string('status', 100)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_assets');
    }
};
