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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('district_code', 100)->nullable()->unique()->comment('선거구 코드');
            $table->string('name', 100)->unique()->comment('선거구 이름');
            $table->foreignId('region_id')->nullable()->comment('지역 테이블 참조 (외래 키)')->constrained('regions')->onDelete('cascade');
            $table->integer('population')->nullable()->comment('인구수');
            $table->string('type', 50)->nullable()->comment('선거구 유형 (예: 광역');
            $table->timestamps();
            $table->comment('선거구');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
