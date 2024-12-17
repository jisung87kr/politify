<x-app-layout>
    @if(!request()->routeIs('member.index'))
    <x-slot name="header">
        <a href="{{ route('term.member.index', $term ?? config('app.currentTermId')) }}" class="px-3 @if(request()->routeIs('term.member.index')) font-bold @endif">국회의원현황</a>
        <a href="{{ route('statistics') }}" class="px-3 @if(request()->routeIs('statistics')) font-bold @endif">통계</a>
    </x-slot>
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form class="max-w-lg mx-auto mt-10" method="GET">
            <div class="flex flex-col">
                @isset($parties)
                <select name="party_name"
                        id=""
                        class="mb-3 block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mr-3">
                    <option value="">전체</option>
                    @foreach($parties as $party)
                    <option value="{{$party->name}}" @selected($party->name == request()->input('party_name'))>{{ $party->name }}</option>
                    @endforeach
                </select>
                @endisset
                <div class="relative w-full">
                    <input type="search" name="name" id="search-dropdown"
                           value="{{ request()->input('name') }}"
                           class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="이름 검색" />
                </div>
                <div class="text-center">
                    <button type="submit"
                            class="flex mt-3 mx-auto gap-3 p-2.5 px-8 text-sm font-medium h-full text-white bg-gray-800 rounded-lg border border-gray-700 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300">
                        <span class="">검색</span>
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mt-10">
            @foreach($members as $member)
                <div class="w-full bg-white border-1 rounded-lg shadow">
                    <div class="flex flex-col items-center py-5 md:py-10 px-4">
                        <div class="w-24 h-24 mb-1 rounded-full shadow-lg relative overflow-hidden mb-3 border">
                            <img class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                 src="{{ $member->thumb_url }}" alt="{{$member->name_kr}}"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{$member->name_en}}&color=7F9CF5&background=EBF4FF&size=100';"
                            />
                        </div>
                        <div class="flex gap-1 items-center">
                            <h5 class="text-xl font-medium text-gray-900">{{ $member->name_kr }}</h5>
                            <span class="text-sm text-gray-500" style="color: {{ $member->party_color }}">({{ $member->last_party }})</span>
                        </div>
                        <a href="mailto:{{ $member->emails[0] }}" class="text-gray-500">{!! isset($member->emails[0]) && $member->emails[0] ? $member->emails[0] : '&nbsp;' !!}</a>
                        <div class="w-full mt-5 px-10 lg:px-5 xl:px-7 flex-1">
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[60px]">당선대수</div>
                                <div class="text-sm text-gray-800 break-keep w-full">{{ $member->last_term_number ?? '-' }}</div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[60px]">지역</div>
                                <div class="text-sm text-gray-800 break-keep w-full">{{ $member->last_district ? $member->last_district : '-' }}</div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[60px]">생년월일</div>
                                <div class="text-sm text-gray-800 break-keep">{{ $member->birth_date }} ({{ $member->age }}세) </div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[60px]">대표번호</div>
                                <div class="text-sm text-gray-800 break-keep">
                                    <a href="tel:{{ $member->phone_numbers[0] }}">{{ isset($member->phone_numbers[0]) && $member->phone_numbers[0] ? $member->phone_numbers[0] : '-' }}</a>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[60px]">홈페이지</div>
                                <div class="text-sm text-gray-800 break-keep">
                                    <a href="{{ $member->homepage_url }}" target="_blank">바로가기</a>
                                </div>
                            </div>
                        </div>
                        @if($member->last_end >= 10)
                        <div class="flex mt-4 md:mt-6">
                            <a href="{{ route('member.show', $member) }}"
                               class="!font-bold text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">자세히보기</a>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center my-6">
            {{ $members->links() }}
        </div>
    </div>
</x-app-layout>
