<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('code', 100)->unique()->index();
            $table->string('type', 50)->index();
            $table->decimal('value')->index();
            $table->string('status', 50)->index();
            $table->timestamp('started_at')->index()->nullable();
            $table->timestamp('ended_at')->index()->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
