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
        Schema::create('sales_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('type')->default('online'); // online, physical, marketplace
            $table->string('status')->default('active'); // active, inactive
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        // Add channel_id to sale_items table
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreignId('channel_id')->nullable()->after('sale_id')
                ->constrained('sales_channels')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['channel_id']);
            $table->dropColumn('channel_id');
        });

        Schema::dropIfExists('sales_channels');
    }
}; 