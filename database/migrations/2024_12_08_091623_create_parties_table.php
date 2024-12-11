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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('party_code', 20)->nullable()->unique()->comment('정당 코드');
            $table->string('name', 100)->unique()->comment('정당 이름');
            $table->string('abbreviation', 20)->nullable()->comment('약칭');
            $table->string('leader', 100)->nullable()->comment('대표자 이름');
            $table->date('founded_date')->nullable()->comment('창당일');
            $table->text('description')->nullable()->comment('정당 설명');
            $table->string('logo_url', 255)->nullable()->comment('정당 로고 URL');
            $table->timestamps();
            $table->comment('정당 정보');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
