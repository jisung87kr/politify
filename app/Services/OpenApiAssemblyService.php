<?php
namespace App\Services;
use App\Models\Region;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;

class OpenApiAssemblyService{
    public function crawlDistricts(Region $region)
    {
        try {
            $cacheKeyName = "crawlDistricts{$region->region_code}";
            $result = Cache::remember($cacheKeyName, 600, function() use ($region){
                $client = new Client;
                //401 에러나면 쿠키, X-Csrf-Token 변경
                $headers = [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                    'X-Csrf-Token' => 'b2df9161-85c4-4edc-b67b-f37d8b692d11',
                    'referer' => 'https://www.assembly.go.kr/portal/cnts/cntsCont/dataA.do?cntsDivCd=NAAS&menuNo=600137',
                    'Cookie' => 'PHAROSVISITOR=000007950193a44235fa3e8b0ac965a6; _gid=GA1.3.1158525744.1733626510; _ga_4KK8WMNECD=GS1.1.1733626541.1.1.1733627611.0.0.0; _fwb=4BBHBvJm0u0GlGM6qZqMe.1733627622802; PCID=cc5534f9-d599-b66b-54f1-2464c5e298a6-1733627623175; PHAROSVISITOR=000007950193a4423aca3eb80ac965a6; _ga=GA1.1.1363082432.1733626510; _ga_LWN7D20CP3=GS1.1.1733644077.2.0.1733644077.0.0.0; ssotoken=; JSESSIONID=31FVK3u7zri71YD6K6aTa2VASC2946Pn6iHVqhZTB93gJuugvWznqPkikLJQwLhV.amV1c19kb21haW4vbmFob21lMg==; wcs_bt=1a0c69697fe3410:1733659789; _ga_8FY090CL6Y=GS1.1.1733658661.5.1.1733660097.0.0.0; PHAROSVISITOR=000002750193a5ae601f46850ac965a5; JSESSIONID=vdxXqnyguUHfidEYHfMkZQOpT1qf1y5z6ChO2MSOWhbWrwdfvGCZ4ITVSadPiiub.amV1c19kb21haW4vbmFob21lMg=='
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

    public function crawlParties()
    {
        $result = [];
        return $result;
    }

    public function crawlTerms()
    {
        $result = [];
        return $result;
    }
}
