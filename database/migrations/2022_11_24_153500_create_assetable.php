<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assetables', static function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id')->index();
            $table->unsignedBigInteger('assetable_id')->index();
            $table->string('assetable_type')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assetables');
    }
};
