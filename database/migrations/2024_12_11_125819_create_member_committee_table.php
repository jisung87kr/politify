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
        Schema::create('member_committee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->comment('의원 ID')->constrained()->onDelete('cascade');
            $table->foreignId('committee_id')->comment('소속 위원회 ID')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_committee');
    }
};
