<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('funeral_services', function (Blueprint $table) {
            $table->foreignId('graveyard_id')->nullable()->after('customer_id')
                ->constrained('graveyards')->nullOnDelete();
            $table->foreignId('chapel_id')->nullable()->after('graveyard_id')
                ->constrained('chapels')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funeral_services', function (Blueprint $table) {
            $table->dropForeign(['chapel_id']);
            $table->dropForeign(['graveyard_id']);
            $table->dropColumn(['chapel_id', 'graveyard_id']);
        });
    }
};
