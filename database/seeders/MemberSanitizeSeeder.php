<?php

namespace Database\Seeders;

use App\Services\MemberSanitizeService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSanitizeSeeder extends Seeder
{
    public function __construct(MemberSanitizeService $memberSanitizeService)
    {
        $this->memberSanitizeService = $memberSanitizeService;
    }
    public function run(): void
    {
        $this->memberSanitizeService->insertTerms();
    }
}
