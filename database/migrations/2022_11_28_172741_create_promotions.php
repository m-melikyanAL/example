<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique()->nullable();
            $table->string('message', 100)->nullable();
            $table->string('type', 100)->index();
            $table->string('status', 100)->index();
            $table->timestamp('started_at')->index()->nullable();
            $table->timestamp('ended_at')->index()->nullable();
            $table->string('frequency', 100)->nullable();
            $table->string('day_of_week', 100)->index()->nullable();
            $table->longText('description')->nullable();
            $table->json('guest_types')->nullable();
            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
