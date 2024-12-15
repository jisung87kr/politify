<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberTerm;
use App\Models\Party;
use App\Services\NewsService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $newsService;
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $filters = request()->all();
        $parties = null;
        if(request()->routeIs('home')) {
            $parties = Party::whereHas('members', function ($query) {
                $query->where('term_id', 22);
            })->get();
            $members = Member::filter($filters)->where('term_number', 'LIKE', '%22%')->paginate(20);
        } else {
            $members = Member::filter($filters)->paginate(20);
        }
        return view('home', compact('members', 'parties'));
    }

    public function show(Member $member, Request $request)
    {
        $display = 100;
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'sim');
        $start = ($page - 1) * $display + 1;
        $query = "{$member->name_kr} {$member->last_party}";
        $news = $this->newsService->getNaverApiNews($query, 100, $start, $sort);
        $news = json_decode($news, true);
        return view('member.show', compact('member', 'news'));
    }
}
