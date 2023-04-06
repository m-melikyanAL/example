<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('message_templates', static function (Blueprint $table) {
            $table->string('type', 100)->index()->nullable()->after('slug');
            $table->boolean('is_automated')->default(false)->after('type');
            $table->boolean('auto_send')->default(false)->after('is_automated');
            $table->date('date')->nullable()->after('message');
            $table->time('time')->nullable()->after('date');
            $table->string('days', 50)->nullable()->after('time');
            $table->string('number_of_days', 50)->nullable()->after('days');
        });
    }

    public function down(): void
    {
        Schema::table('message_templates', static function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'is_automated',
                'auto_send',
                'date',
                'time',
                'days',
                'number_of_days',
            ]);
        });
    }
};
