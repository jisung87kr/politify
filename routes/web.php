<?php

use App\Models\Member;
use App\Models\Region;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $members = Member::paginate(20);
    dd($members);
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
