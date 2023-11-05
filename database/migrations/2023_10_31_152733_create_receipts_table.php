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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('amount')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_number')->nullable();
            $table->string('to_name')->nullable();
            $table->string('to_number')->nullable();
            $table->string('date')->nullable();
            $table->string('purpose')->nullable();
            $table->string('reference')->nullable();
            $table->string('memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
