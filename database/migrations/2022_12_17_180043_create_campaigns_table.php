<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->index();

            $table->unsignedBigInteger('promotion_id')->index()->nullable();

            $table->json('client_types')->nullable();
            $table->json('channels')->nullable();
            $table->mediumText('message')->nullable();

            $table->timestamp('sent_at')->index()->nullable();
            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
