<?php
namespace App\Services;
use App\Models\Region;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenApiAssemblyService{
    private $openApiKey;
    private $pageSize = 100;
    public function __construct()
    {
        $this->openApiKey = env('ASSEMBLY_OPEN_API_KEY');
    }
    public function crawlDistricts(Region $region)
    {
        try {
            $cacheKeyName = "crawlDistricts{$region->region_code}";
            $result = Cache::remember($cacheKeyName, 600, function() use ($region){
                $client = new Client;
                //401 에러나면 쿠키, X-Csrf-Token 변경
                $headers = [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                    'X-Csrf-Token' => '9ba4c1c2-bd8a-4381-bba9-a1448588488d',
                    'referer' => 'https://www.assembly.go.kr/portal/cnts/cntsCont/dataA.do?cntsDivCd=NAAS&menuNo=600137',
                    'Cookie' => 'PHAROSVISITOR=000015620193b56aab4d56da0ac965a5; _ga_4KK8WMNECD=GS1.1.1733626541.1.1.1733627611.0.0.0; _fwb=4BBHBvJm0u0GlGM6qZqMe.1733627622802; PCID=cc5534f9-d599-b66b-54f1-2464c5e298a6-1733627623175; _gid=GA1.3.99858042.1733915512; _ga_LWN7D20CP3=GS1.1.1733915511.8.1.1733916785.0.0.0; _ga=GA1.1.1363082432.1733626510; JSESSIONID=VVlT33raFaFZCOljqENlvcR5nB4cMErm91zT4tvpAYDbaEMWvQi3Z4tORzTi1SpK.amV1c19kb21haW4vbmFob21lMQ==; wcs_bt=1a0c69697fe3410:1733923988; _ga_8FY090CL6Y=GS1.1.1733923936.16.1.1733923988.0.0.0'
                ];
                $options = [
                    'multipart' => [
                        [
                            'name' => 'grpComCd',
                            'contents' => 'ORIG_CD'
                        ],
                        [
                            'name' => 'upComCd',
                            'contents' => $region->region_code,
                        ]
                    ]];
                $request = new Request('POST', 'https://www.assembly.go.kr/portal/cnts/cntsNaas/findThxCodeJson.json', $headers);
                $res = $client->sendAsync($request, $options)->wait();
                return json_decode($res->getBody());
            });

            return $result;
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function getMembers($page=1)
    {
        $options = [
            'query' => [
                'KEY' => $this->openApiKey,
                'type' => 'json',
                'pIndex' => $page,
                'pSize' => $this->pageSize,
                'NAAS_NM' => '',
                'PLPT_NM' => '',
                'BLNG_CMIT_NM' => ''
            ]
        ];
        $cacheKeyName = http_build_query($options);

        $result = Cache::remember($cacheKeyName, '600', function() use ($page, $options){
            $client = new Client();
            $headers = [];

            $request = new Request('GET', 'https://open.assembly.go.kr/portal/openapi/ALLNAMEMBER', $headers);
            $res = $client->sendAsync($request, $options)->wait();
            return json_decode($res->getBody());
        });
        return $result;
    }

    public function getAllMembers()
    {
        $client = new Client();

        // 첫 번째 페이지 데이터 캐시 확인
        $cacheKeyFirstPage = "members_page_1";
        $firstPage = Cache::remember($cacheKeyFirstPage, 3600, function () {
            return $this->getMembers(1);
        });

        $totalCount = $firstPage->ALLNAMEMBER[0]->head[0]->list_total_count;
        $totalPage = ceil($totalCount / $this->pageSize); // 정확한 페이지 수 계산

        $promises = [];
        $result = [
            1 => $firstPage, // 첫 번째 페이지는 캐시에서 가져온 데이터로 초기화
        ];

        for ($page = 2; $page <= $totalPage; $page++) {
            $cacheKey = "members_page_$page";

            // 캐시가 존재하면 바로 결과에 추가
            if (Cache::has($cacheKey)) {
                $result[$page] = Cache::get($cacheKey);
            } else {
                // 캐시가 없으면 비동기 요청 생성
                $options = [
                    'query' => [
                        'KEY' => $this->openApiKey,
                        'type' => 'json',
                        'pIndex' => $page,
                        'pSize' => $this->pageSize,
                        'NAAS_NM' => '',
                        'PLPT_NM' => '',
                        'BLNG_CMIT_NM' => ''
                    ]
                ];

                $promises[$page] = $client->requestAsync('GET', 'https://open.assembly.go.kr/portal/openapi/ALLNAMEMBER', $options);
            }
        }

        // 비동기 요청 처리
        if (!empty($promises)) {
            $responses = Promise\Utils::settle($promises)->wait();

            foreach ($responses as $page => $response) {
                if ($response['state'] === 'fulfilled') {
                    $body = json_decode($response['value']->getBody());
                    $result[$page] = $body;

                    // 캐시에 저장
                    Cache::put("members_page_$page", $body, 3600);
                } else {
                    // 요청 실패 시의 오류 처리
                    Log::error("HTTP request for page $page failed: " . $response['reason']);
                }
            }
        }

        // 페이지 순서대로 정렬
        ksort($result);

        return $result;
    }

    public function getBills($page=1, $age)
    {
        $options = [
            'query' => [
                'KEY' => $this->openApiKey,
                'type' => 'json',
                'pIndex' => $page,
                'pSize' => $this->pageSize,
                'AGE' => $age,
            ]
        ];
        $cacheKeyName = http_build_query($options);

        $result = Cache::remember($cacheKeyName, 3600 * 24, function() use ($page, $options){
            $client = new Client();
            $headers = [];

            $request = new Request('GET', 'https://open.assembly.go.kr/portal/openapi/nzmimeepazxkubdpn', $headers);
            $res = $client->sendAsync($request, $options)->wait();
            return json_decode($res->getBody());
        });
        return $result;
    }

    public function getAllBills($age)
    {
        $client = new Client();

        // 첫 번째 페이지 데이터 캐시 확인
        $cacheKeyFirstPage = "bills_{$age}_page_1";
        $firstPage = Cache::remember($cacheKeyFirstPage, 3600 * 24, function () use ($age){
            return $this->getBills(1, $age);
        });

        $totalCount = $firstPage->nzmimeepazxkubdpn[0]->head[0]->list_total_count;
        $totalPage = ceil($totalCount / $this->pageSize); // 정확한 페이지 수 계산

        $promises = [];
        $result = [
            1 => $firstPage, // 첫 번째 페이지는 캐시에서 가져온 데이터로 초기화
        ];

        for ($page = 2; $page <= $totalPage; $page++) {
            $cacheKey = "bills_{$age}_page_$page";

            // 캐시가 존재하면 바로 결과에 추가
            if (Cache::has($cacheKey)) {
                $result[$page] = Cache::get($cacheKey);
            } else {
                // 캐시가 없으면 비동기 요청 생성
                $options = [
                    'query' => [
                        'KEY' => $this->openApiKey,
                        'type' => 'json',
                        'pIndex' => $page,
                        'pSize' => $this->pageSize,
                        'AGE' => $age,
                    ]
                ];

                $promises[$page] = $client->requestAsync('GET', 'https://open.assembly.go.kr/portal/openapi/nzmimeepazxkubdpn', $options);
            }
        }

        // 비동기 요청 처리
        if (!empty($promises)) {
            $responses = Promise\Utils::settle($promises)->wait();

            foreach ($responses as $page => $response) {
                if ($response['state'] === 'fulfilled') {
                    $body = json_decode($response['value']->getBody());
                    $result[$page] = $body;

                    // 캐시에 저장
                    Cache::put("bills_page_$page", $body, 3600 * 24);
                } else {
                    // 요청 실패 시의 오류 처리
                    Log::error("HTTP request for page $page failed: " . $response['reason']);
                }
            }
        }

        // 페이지 순서대로 정렬
        ksort($result);

        return $result;
    }
}
