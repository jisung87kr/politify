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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('term_code', 20)->nullable()->comment('대수 코드');
            $table->string('name', 50)->unique()->comment('국회 회기명 (예: 제21대)');
            $table->date('start_date')->nullable()->comment('회기 시작일');
            $table->date('end_date')->nullable()->comment('회기 종료일');
            $table->text('description')->nullable()->comment('회기 설명');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
