@use(Carbon\Carbon)
<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('news') }}" class="px-3 @if(request()->routeIs('news')) font-bold @endif">뉴스</a>
        <a href="{{ route('nblog') }}" class="px-3 @if(request()->routeIs('nblog')) font-bold @endif">블로그</a>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="divide-y bg-white rounded-xl mt-6">
            @foreach($paginator as $item)
            <section class="px-7 py-5">
                <div class="flex">
                    <div>
                        <h1 class="font-bold text-lg">
                            <a href="https://blog.naver.com/{{ $item['blogId'] }}/{{ $item['logNo'] }}" target="_black" class="break-all">{!! strip_tags($item['title']) !!}</a>
                        </h1>
                        <div>
                            <a href="https://blog.naver.com/{{ $item['blogId'] }}" target="_blank"><small>{{ $item['nickName'] }}</small></a>
                            <small>∙</small>
                            <small class="text-gray-500">
                                {{ Carbon::createFromTimestamp(intval($item['addDateTimeStamp'] / 1000))->diffForHumans() }}
                            </small>
                        </div>
                        <div class="mt-3 text-gray-700">
                            <a href="https://blog.naver.com/{{ $item['blogId'] }}/{{ $item['logNo'] }}" target="_blank" class="line-clamp-2 break-all">
                                {!! strip_tags($item['briefContents'])  !!}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $paginator->links() }}
        </div>
    </div>

</x-app-layout>
