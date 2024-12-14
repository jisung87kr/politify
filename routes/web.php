<?php

use App\Http\Controllers\MemberController;
use App\Models\Member;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/', [MemberController::class, 'index'])->name('home');
Route::get('/members', [MemberController::class, 'index'])->name('member.index');
Route::get('/members/{member}', [MemberController::class, 'show'])->name('member.show');

Route::get('/news', function (Request $request, \App\Services\NewsService $newsService) {
    $display = 100;
    $page = $request->get('page', 1);
    $sort = $request->get('sort', 'date');
    $totalPage = 10;

    $page = $page > $totalPage ? $totalPage : $page;

    $start = ($page - 1) * $display + 1;
    $news = $newsService->getNaverApiNews('정치', 100, $start, $sort);
    $news = json_decode($news, true);


    $paginator = new LengthAwarePaginator(
        $news['items'], // 현재 페이지의 데이터
        $totalPage * $display,         // 전체 데이터 개수
        $display,             // 페이지당 항목 수
        $page,         // 현재 페이지 번호
        ['path' => request()->url()] // URL 경로 설정
    );

    return view('news', compact('paginator', 'sort'));
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
