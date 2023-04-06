<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->index()->nullable();
            $table->string('name')->index();
            $table->string('last_name')->index()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('salutation', 50)->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_country_code', 50)->nullable();
            $table->string('status', 100)->index()->nullable();
            $table->date('born_at')->nullable();
            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
