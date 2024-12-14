<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberTerm;
use App\Models\Party;
use Illuminate\Http\Request;

class MemberController extends Controller
{

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

    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }
}
