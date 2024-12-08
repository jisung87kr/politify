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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code', 20)->unique()->comment('국회의원 고유 코드');
            $table->string('name_kr', 100)->comment('국회의원 이름 (한글)');
            $table->string('name_ch', 100)->nullable()->comment('국회의원 이름 (한자)');
            $table->string('name_en', 100)->nullable()->comment('국회의원 이름 (영문)');
            $table->string('birth_type', 10)->nullable()->comment('생일 구분 코드');
            $table->date('birth_date')->comment('생년월일');
            $table->string('position', 50)->nullable()->comment('직책명');
            $table->string('party_name', 100)->nullable()->comment('정당명');
            $table->string('district_name', 100)->nullable()->comment('선거구명');
            $table->string('district_type', 50)->nullable()->comment('선거구 구분명');
            $table->string('committee_name', 100)->nullable()->comment('위원회명');
            $table->string('affiliated_committee', 100)->nullable()->comment('소속 위원회명');
            $table->string('reelection_status', 50)->nullable()->comment('재선 구분명');
            $table->string('term_number', 10)->nullable()->comment('당선 대수');
            $table->string('gender', 10)->nullable()->comment('성별');
            $table->string('phone_number', 20)->nullable()->comment('전화번호');
            $table->string('email', 150)->nullable()->comment('국회의원 이메일 주소');
            $table->string('homepage_url', 255)->nullable()->comment('국회의원 홈페이지 URL');
            $table->text('aides')->nullable()->comment('보좌관 이름 (쉼표로 구분)');
            $table->text('chief_secretaries')->nullable()->comment('비서관 이름 (쉼표로 구분)');
            $table->text('secretaries')->nullable()->comment('비서진 이름 (쉼표로 구분)');
            $table->text('brief_history')->nullable()->comment('약력');
            $table->string('office_room', 50)->nullable()->comment('사무실 호실');
            $table->string('photo_url', 255)->nullable()->comment('국회의원 사진 URL');
            $table->timestamps();
            $table->comment('국회의원 정보');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
