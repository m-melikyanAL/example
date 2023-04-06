<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->index()->nullable();
            $table->string('type')->index();
            $table->decimal('value')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->foreignId('approved_by')->nullable()->index();
            $table->string('room_number')->nullable()->index();
            $table->text('qr_data')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable()->index();
            $table->unsignedBigInteger('booking_room_id')->nullable()->index();
            $table->string('phone_number')->nullable()->index();
            $table->string('phone_country_code', 50)->nullable();
            $table->string('title')->nullable()->index();
            $table->text('description')->nullable();
            $table->timestamp('used_at')->nullable()->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
