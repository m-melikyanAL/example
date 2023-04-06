<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taggables', static function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->index();
            $table->unsignedBigInteger('taggable_id')->index();
            $table->string('taggable_type')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
