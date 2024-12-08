<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>--}}
{{--    </x-slot>--}}
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
                            class="flex mt-3 mx-auto gap-3 p-2.5 px-8 text-sm font-medium h-full text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
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
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <div class="flex flex-col items-center py-10 px-4">
                        <div class="w-24 h-24 mb-3 rounded-full shadow-lg relative overflow-hidden">
                            <img class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" src="{{ $member->photo_url }}" alt="Bonnie image"/>
                        </div>
                        <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $member->name_kr }}</h5>
                        <span class="text-sm text-gray-500">{{ $member->party_name }}</span>
                        <div class="w-full mt-5 text-center">
                            <div class="mb-2">
                                <div class="text-sm text-gray-500">소속위왼회</div>
                                <div class="text-sm text-gray-800 break-keep">{{ $member->committee_name }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-sm text-gray-500">지역</div>
                                <div class="text-sm text-gray-800 break-keep">{{ $member->district_name }}</div>
                            </div>
                            <div class="">
                                <div class="text-sm text-gray-500">당선횟수</div>
                                <div class="text-sm text-gray-800 break-keep">{{ $member->reelection_status }}</div>
                            </div>
                        </div>
                        <div class="flex mt-4 md:mt-6">
                            @if(request()->routeIs('home'))
                            <a href="https://www.assembly.go.kr/members/22st/{{ str_replace(' ', '', $member->name_en) }}"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">홈페이지</a>
                            @endif
                            <a href="https://www.assembly.go.kr/portal/assm/assmPrpl/prplMst.do?monaCd={{ $member->member_code }}&st=22&viewType=CONTBODY&tabId=repbill"
                               target="_blank"
                               class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">대표발의안</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center my-6">
            {{ $members->links() }}
        </div>
    </div>
</x-app-layout>