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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_code')->comment('법안 고유 식별자')->unique();
            $table->string('bill_number')->comment('법안 번호');
            $table->string('bill_name')->comment('법안 제목');
            $table->string('committee_name')->nullable()->comment('소관 상임위원회 이름');
            $table->timestamp('proposed_date')->comment('발의 날짜');
            $table->string('process_result')->nullable()->comment('처리 결과');
            $table->foreignId('term_id')->nullable()->constrained();
            $table->integer('assembly_age')->comment('국회 회기 (예: 22대 국회)');
            $table->string('detail_link', 2083)->nullable()->comment('법안 상세 정보 URL');
            $table->string('main_proposer')->nullable()->comment('대표 발의자 및 발의 인원 정보');
            $table->string('member_list_link', 2083)->nullable()->comment('발의자 명단 URL');
            $table->timestamp('law_processed_date')->nullable()->comment('법안 처리 날짜');
            $table->timestamp('law_presented_date')->nullable()->comment('본회의 제출 날짜');
            $table->timestamp('law_submitted_date')->nullable()->comment('법안 제출 날짜');
            $table->string('committee_result_code')->nullable()->comment('상임위 처리 결과 코드');
            $table->timestamp('committee_processed_date')->nullable()->comment('상임위 처리 날짜');
            $table->timestamp('committee_presented_date')->nullable()->comment('상임위 제출 날짜');
            $table->timestamp('committee_date')->nullable()->comment('상임위 일정 날짜');
            $table->timestamp('processed_date')->nullable()->comment('전체 법안 처리 날짜');
            $table->string('committee_id')->nullable()->comment('소관 상임위 고유 ID');
            $table->text('public_proposers')->nullable()->comment('공개된 발의자 명단');
            $table->string('law_result_code')->nullable()->comment('법안 최종 처리 결과 코드');
            $table->string('representative_proposer')->nullable()->comment('대표 발의자 이름');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
