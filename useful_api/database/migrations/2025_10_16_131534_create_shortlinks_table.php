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
        Schema::create('shortlinks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            // $table->foreignId('module_id')->nullable()->index();
            $table->string('original_url')->nullable();
            $table->string('custom_code')->nullable();
            $table->string('code')->nullable()->unique();
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });

  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('shortlinks');
    }
};
