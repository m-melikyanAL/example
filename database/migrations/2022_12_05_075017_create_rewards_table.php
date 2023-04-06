<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rewards', static function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_from');
            $table->decimal('amount_to');
            $table->string('type', 50);
            $table->decimal('value');
            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
