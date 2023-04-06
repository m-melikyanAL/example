<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_asset_promotion', function (Blueprint $table) {
            $table->unsignedBigInteger('digital_asset_id')->index();
            $table->unsignedBigInteger('promotion_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_asset_promotion');
    }
};
