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
        Schema::table('waitlists', function (Blueprint $table) {
            $table->integer('requested_quantity')->default(1)->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waitlists', function (Blueprint $table) {
            $table->dropColumn('requested_quantity');
        });
    }
};
