<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'promotions',
        'magazines',
        'blacklist_phones',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, static function (Blueprint $blueprint) {
                $blueprint->unsignedBigInteger('old_id')
                    ->after('id')
                    ->index()
                    ->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, static function (Blueprint $blueprint) {
                $blueprint->dropColumn('old_id');
            });
        }
    }
};
