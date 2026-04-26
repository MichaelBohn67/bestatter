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
            $table->unique('deceased_id', 'funeral_services_deceased_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funeral_services', function (Blueprint $table) {
            $table->dropUnique('funeral_services_deceased_id_unique');
        });
    }
};
