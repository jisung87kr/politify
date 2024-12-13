<?php

use App\Models\Member;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/statistics', function (Request $request, \App\Services\StaticsService $staticsService) {
    // 정당별 의원현황, 당성횟수별 의원현황, 성별 의원현황, 연령별 의원현황
    $parties = $staticsService->getPartyMembers(22);
    $termNumbers = $staticsService->getTermNumbers(22);
    $gender = $staticsService->getGenders(22);
    $ageGroups = $staticsService->getAgeGroups(22);
//    dd($parties);
    $statistics = [
        'parties' => $parties,
        'termNumbers' => $termNumbers,
        'gender' => $gender,
        'ageGroups' => $ageGroups,
    ];

    return view('statistics', compact('statistics'));
})->name('statistics');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/user/{user}', function (User $user) {
//    if (! request()->hasValidSignature()) {
//        abort(401);
//    }
    $url = URL::signedRoute('unsubscribe', ['user' => 1]);
    dd($url, $user);
})->name('unsubscribe')->middleware('signed');
