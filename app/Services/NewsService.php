<?php
namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class NewsService{
    private $client;
    public $naverClientID;
    public $naverCclientSecret;
    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->naverClientID = env('NAVER_CLIENT_ID');
        $this->naverCclientSecret = env('NAVER_CLIENT_SECRET');
    }
    //sort = date(등록일) / sim(연관도)
    public function getNaverApiNews($query, $display = 10, $start = 1, $sort = 'date'){
        $url = 'https://openapi.naver.com/v1/search/news.json';
        $params = [
            'query' => $query,
            'display' => $display,
            'start' => $start,
            'sort' => $sort
        ];

        $queryString = http_build_query($params);
        $headers = [
            'X-Naver-Client-Id' => $this->naverClientID,
            'X-Naver-Client-Secret' => $this->naverCclientSecret
        ];

        return Cache::remember('naver_news_' . md5($queryString), 60 * 10, function () use ($url, $queryString, $headers) {
            $response = $this->client->get($url . '?' . $queryString, [
                'headers' => $headers
            ]);

            return $response->getBody()->getContents();
        });
    }
}
