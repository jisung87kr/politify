<?php
namespace App\View\Composers;


use Illuminate\View\View;

class SEOComposer{
    public function compose(View $view){
        $url = request()->url();
        $title = config('app.name', '폴리티파이');
        $description = "{$title} - 생각을 나누다, 정치를 바꾸다. 정치를 쉽게 이해하고, 시민들이 함께 소통하며 변화를 만들어가는 온라인 정치 커뮤니티입니다.";
        $keywords = "정치 커뮤니티,정치 참여,시민 소통,정치 토론,정치 정보,민주주의,정치 뉴스,온라인 커뮤니티,정치 의견 나누기,정치 변화";
        $image = 'https://via.placeholder.com/150';
        $author = $title;

        switch (request()->route()->getName()){
            case 'home':
                $title = config('app.name', '폴리티파이') . ' - 국회의왼현황';
                break;
            case 'member':
                $title = config('app.name', '폴리티파이') . ' - 역대 국회의왼현황';
                break;
            case 'statistics':
                $title = config('app.name', '폴리티파이') . ' - 국회의원 통계';
                break;
            case 'news':
                $title = config('app.name', '폴리티파이') . ' - 뉴스';
                break;
            default:
                break;
        }


        $jsonld = [
            "@context"    => "https://schema.org",
            "@type"       => "WebPage",
            "name"        => $title,
            "description" => $description,
            "url"         => $url,
            "publisher"   => [
                "@type" => "Organization",
                "name"  => $author,
            ],
        ];

        $seoData = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'author' => $author,
            'jsonld' => $jsonld,
        ];

        $view->with('seoData', $seoData);
    }
}
