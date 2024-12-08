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
        Schema::create('member_term', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->comment('의원 ID')->constrained()->onDelete('cascade');
            $table->foreignId('term_id')->comment('대수 ID')->constrained()->onDelete('cascade');
            $table->foreignId('party_id')->comment('정당 ID')->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->comment('선거구 ID')->constrained()->onDelete('cascade');
            $table->string('district_type')->comment('선거구 구분명');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_member_term');
    }
};
