<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blacklist_phones', static function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')
                ->nullable()
                ->index()
                ->after('old_id');
        });
    }
    public function down(): void
    {
        Schema::table('blacklist_phones', static function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
};
