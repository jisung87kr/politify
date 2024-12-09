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
                <div class="w-full bg-white border-2 rounded-lg shadow" style="border-color: {{ $member->party_color }}">
                    <div class="flex flex-col items-center py-10 px-4">
                        <div class="w-24 h-24 mb-1 rounded-full shadow-lg relative overflow-hidden mb-3 border">
                            <img class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" src="{{ $member->photo_url }}" alt="Bonnie image"/>
                        </div>
                        <div class="flex gap-1 items-center">
                            <h5 class="text-xl font-medium text-gray-900">{{ $member->name_kr }}</h5>
                            <span class="text-sm text-gray-500">({{ $member->last_party }})</span>
                        </div>
                        <a href="mailto:{{ $member->emails[0] }}" class="text-gray-500">{{ $member->emails[0] }}</a>
                        <div class="w-full mt-5 px-5 lg:px-5 xl:px-7">
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[50px]">당선대수</div>
                                <div class="text-sm text-gray-800 break-keep w-full">{{ $member->last_term_number ?? '-' }}</div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[50px]">지역</div>
                                <div class="text-sm text-gray-800 break-keep w-full">{{ $member->last_district ?? '-' }}</div>
                            </div>
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[50px]">생년월일</div>
                                <div class="text-sm text-gray-800 break-keep">{{ $member->birth_date }} ({{ $member->age }}세) </div>
                            </div>
                            @if($member->phone_numbers)
                            <div class="flex">
                                <div class="text-sm text-gray-500 mr-3 shrink-0 w-[50px]">대표번호</div>
                                <div class="text-sm text-gray-800 break-keep">
                                    <a href="tel:{{ $member->phone_numbers[0] }}">{{ $member->phone_numbers[0] ?? '-' }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($member->last_end > 18)
                        <div class="flex mt-4 md:mt-6">
                            <a href="{{ $member->homepage_url }}"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">홈페이지</a>
                            <a href="{{ $member->bill_url }}"
                               target="_blank"
                               class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">대표발의안</a>
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
