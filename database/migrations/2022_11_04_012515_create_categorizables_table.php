<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorizables', static function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('categorizable_id')->index();
            $table->string('categorizable_type')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorizables');
    }
};
