@use(Carbon\Carbon)
<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>--}}
{{--    </x-slot>--}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
