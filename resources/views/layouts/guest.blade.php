<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KTTJ3X7HFZ"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-KTTJ3X7HFZ');
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-MLKS627F');</script>
        <!-- End Google Tag Manager -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $seoData['title'] }}</title>
        <meta name="description" content="{{ $seoData['description'] }}">
        <meta name="keywords" content="{{ $seoData['keywords'] }}">
        <meta name="author" content="{{ $seoData['author'] }}">

        <!-- Open Graph 메타 태그 (소셜 미디어 공유용) -->
        <meta property="og:title" content="{{ $seoData['title'] }}">
        <meta property="og:description" content="{{ $seoData['description'] }}">
        <meta property="og:image" content="{{ $seoData['image'] }}">
        <meta property="og:url" content="{{ $seoData['url'] }}">
        <meta property="og:type" content="website">

        <!-- 트위터 카드 메타 태그 -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoData['title'] }}">
        <meta name="twitter:description" content="{{ $seoData['description'] }}">
        <meta name="twitter:image" content="{{ $seoData['image'] }}">

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $seoData['url'] }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLKS627F"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts

        <!-- 구조화된 데이터 (JSON-LD) -->
        <script type="application/ld+json">
            {!! json_encode($seoData['jsonld'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    </body>
</html>
