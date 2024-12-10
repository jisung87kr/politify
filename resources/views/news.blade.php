<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight"></h2>--}}
{{--    </x-slot>--}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach($news['items'] as $item)
        <section class="bg-white px-7 py-5 my-5 rounded-2xl shadow-sm">
            <h1 class="font-bold text-lg">
                <a href="{{ $item['link'] }}" target="_black">{!! strip_tags($item['title']) !!}</a>
            </h1>
            <div>
                <small class="text-gray-500">{{ date('m.d H시i분', strtotime($item['pubDate'])) }}</small>
            </div>
            <div class="mt-3 text-gray-700">
                <a href="{{ $item['link'] }}" target="_blank">
                    {{ strip_tags($item['description']) }}
                </a>
            </div>
        </section>
        @endforeach
    </div>
</x-app-layout>
