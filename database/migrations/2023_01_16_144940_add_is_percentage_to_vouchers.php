<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', static function (Blueprint $table) {
            $table->boolean('is_percentage')
                ->after('value')
                ->default(false)
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', static function (Blueprint $table) {
            $table->dropColumn('is_percentage');
        });
    }
};
