<?php

use App\Models\Region;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\App\Services\OpenApiAssemblyService $service) {
    $region = Region::where('name', '서울')->first();
    $result = $service->crawlDistricts($region);
    dd($result->thxCode);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
