<?php

use App\Models\Member;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $filters = $request->all();
    $members = Member::filter($filters)->where('term_number', 'LIKE', '%22%')->paginate(20);
    $parties = \App\Models\Party::all();
    return view('home', compact('members', 'parties'));
})->name('home');

Route::get('/members', function (Request $request) {
    $filters = $request->all();
    $members = Member::filter($filters)->paginate(20);
    return view('home', compact('members'));
})->name('member');

Route::get('/news', function (Request $request, \App\Services\NewsService $newsService) {
    $news = $newsService->getNaverApiNews('정치', 100, 1);
    $news = json_decode($news, true);
    return view('news', compact('news'));
})->name('news');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
