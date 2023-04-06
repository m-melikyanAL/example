<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blacklist_phones', static function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->index();
            $table->mediumText('reason')->nullable();
            $table->string('status', 100)->nullable();
            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blacklist_phones');
    }
};
