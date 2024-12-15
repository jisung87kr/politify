@use(Carbon\Carbon)
<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>--}}
    {{--    </x-slot>--}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl p-6 mt-6">
            <div class="md:flex gap-6">
                <div class="shrink-0 mr-10">
                    <img src="{{ $member->thumb_url }}" alt="" class="w-[200px] rounded-xl overflow-hidden mx-auto shadow">
                    <div class="text-center">
                        <div class="text-xl font-bold pt-2">
                            <span>{{ $member->name_kr }}</span> <span>({{ $member->name_ch }})</span>
                        </div>
                        <div class="text-gray-600" style="color:{{ $member->party_color }}">{{ $member->last_party }}</div>
                        <small class="block text-gray-600">{{ $member->birth_date }} ({{ $member->age }}세)</small>
                    </div>
                </div>
                <div class="w-full">
                    <div class="mb-3 pb-3 border-b">
                        <span class="font-bold text-lg mr-3">의원홈페이지</span>
                        <a href="{{ $member->assembly_url }}" target="_blank" class="break-all">{{ $member->assembly_url }}</a>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-10">
                        <div>
                            <div class="font-bold text-lg border-b pb-2 mb-2">국회의원소개</div>
                            <div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">선거구</div>
                                    <div>{{ $member->last_district }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">소속위원회</div>
                                    <div>{{ $member->committee_name }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">당선횟수</div>
                                    <div>{{ $member->term_number }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">사무실 전화</div>
                                    <div>
                                        <a href="tel:{{ $member->phone_number }}" target="_blank">{{ $member->phone_number }}</a>
                                    </div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">사무실 호실</div>
                                    <div>{{ $member->office_room }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">개별 홈페이지</div>
                                    <div>
                                        <a href="{{ $member->homepage_url }}" target="_blank" class="break-all">{{ $member->homepage_url }}</a>
                                    </div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">이메일</div>
                                    <div>
                                        <a href="mailto:{{ $member->emails[0] }}" class="break-all">{{ $member->emails[0] }}</a>
                                    </div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">보좌관</div>
                                    <div>{{ $member->aides }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">선임비서관</div>
                                    <div>{{ $member->chief_secretaries }}</div>
                                </div>
                                <div class="flex text-gray-600 mb-2">
                                    <div class="w-[100px] mr-4 font-bold shrink-0">비서관</div>
                                    <div>{{ $member->secretaries }}</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-lg border-b pb-2 mb-2">주요약력</div>
                            <div>
                                <div class="flex text-gray-600" style="line-height: 1.8">
                                    <div>{!! nl2br($member->brief_history) !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <section class="bg-white rounded-xl px-6 py-3">
                <h2 class="font-bold text-lg mb-2">대표발의안</h2>
                <ul class="divide-y overflow-y-auto max-h-[500px]">
                    @foreach($member->representativeBills as $bill)
                    <li class="py-3">
                        @if($bill->process_result)
                        <small class="block mb-1">[{{ $bill->process_result }}]</small>
                        @endif
                        <a href="{{ $bill->detail_link }}" target="_blank" class="block font-bold">{{ $bill->bill_name }}</a>
                        <small class="text-gray-600">{{ date('Y-m-d', strtotime($bill->committee_date)) }}</small>
                    </li>
                    @endforeach
                </ul>
            </section>
            <section class="bg-white rounded-xl px-6 py-3">
                <h2 class="font-bold text-lg mb-2">의원 뉴스</h2>
                <ul class="divide-y overflow-y-auto max-h-[500px]">
                    @foreach($news['items'] as $item)
                    <li class="py-3">
                        <a href="{{ $item['link'] }}" target="_black" >
                            <div class="font-bold">
                                {!! strip_tags($item['title']) !!}
                            </div>
                            <div class="line-clamp-1 text-gray-600">
                                {!! strip_tags($item['description'])  !!}
                            </div>
                        </a>
                        <div>
                            <small class="text-gray-600">{{ Carbon::parse($item['pubDate'])->diffForHumans() }}</small>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</x-app-layout>
