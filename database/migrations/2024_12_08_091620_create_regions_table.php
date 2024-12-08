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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('region_code', 100)->unique()->comment('지역 코드 (대한민국 국회 홈페이지용)');
            $table->string('name', 100)->unique()->comment('지역 이름');
            $table->foreignId('parent_id')->nullable()->comment('상위 지역 (self-referencing)')->constrained('regions')->onDelete('cascade');
            $table->integer('population')->nullable()->comment('인구 수');
            $table->string('type', 50)->nullable()->comment('지역 유형 (예: 광역시, 도, 구 등)');
            $table->timestamps();
            $table->comment('지역');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
