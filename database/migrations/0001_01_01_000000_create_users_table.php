<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('gender')->nullable();
            $table->jsonb('name')->nullable();
            $table->jsonb('location')->nullable();
            $table->integer('age')->nullable();
            $table->timestamps();
        });


        Schema::table('users', function (Blueprint $table) {
            $table->index('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
