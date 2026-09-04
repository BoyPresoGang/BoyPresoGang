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
    Schema::create('deliveries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id');
        $table->date('delivery_date');
        $table->string('status');
        $table->timestamps();
    });
}

    public function down(): void
{
    Schema::dropIfExists('deliveries');
}
};
