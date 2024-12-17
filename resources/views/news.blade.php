@use(Carbon\Carbon)
<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('news') }}" class="px-3 @if(request()->routeIs('news')) font-bold @endif">뉴스</a>
        <a href="{{ route('nblog') }}" class="px-3 @if(request()->routeIs('nblog')) font-bold @endif">블로그</a>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mt-6 inline-flex rounded-md shadow-sm text-center">
            <a href="?sort=date" aria-current="page" class="px-4 py-2 text-sm font-medium bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 @if($sort == 'date') text-blue-700 @else text-gray-900 @endif">
                시간순
            </a>
            <a href="?sort=sim" class="px-4 py-2 text-sm font-medium bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 @if($sort == 'sim') text-blue-700 @else text-gray-900 @endif">
                정확도순
            </a>
        </div>
        <div class="divide-y bg-white rounded-xl mt-6">
            @foreach($paginator as $item)
            <section class="px-7 py-5">
                <h1 class="font-bold text-lg">
                    <a href="{{ $item['link'] }}" target="_black">{!! strip_tags($item['title']) !!}</a>
                </h1>
                <div>
                    <small class="text-gray-500">
                        {{ Carbon::parse($item['pubDate'])->diffForHumans() }}
                    </small>
                </div>
                <div class="mt-3 text-gray-700">
                    <a href="{{ $item['link'] }}" target="_blank">
                        {!! strip_tags($item['description'])  !!}
                    </a>
                </div>
            </section>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $paginator->links() }}
        </div>
    </div>

</x-app-layout>
