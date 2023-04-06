<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_reports', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->nullable()->index();
            $table->string('delivery_status')->nullable()->index();
            $table->string('channel')->nullable()->index();
            $table->text('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_reports');
    }
};
