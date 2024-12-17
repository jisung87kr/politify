<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberTerm;
use App\Models\Party;
use App\Models\Term;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MemberController extends Controller
{
    private $newsService;
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(?Term $term = null)
    {
        $filters = request()->all();
        $parties = null;
        if(request()->routeIs('term.member.index')) {
            $parties = Party::whereHas('members', function ($query) use ($term) {
                $query->where('term_id', $term->id);
            })->get();
            $members = Member::filter($filters)->where('term_number', 'LIKE', "%$term->name%")->paginate(20);
        } else {
            $members = Member::filter($filters)->paginate(20);
        }
        return view('member', compact('members', 'parties', 'term'));
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
        $member->load('representativeBills');

        // 소셜미디어
        $socials = [];

        // 네이버블로그
        $blogs = json_decode($this->newsService->getNaverApiBLogs($query, 100, $start, $sort), true);

        View::share('member', $member);
        return view('member.show', compact('member', 'news', 'blogs'));
    }
}
