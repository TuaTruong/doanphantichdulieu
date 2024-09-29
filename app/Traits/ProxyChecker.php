<?php


namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Proxy;

trait ProxyChecker
{
/**
* Kiểm tra xem proxy có live hay không.
*/
public function isProxyLive(Proxy $proxy)
    {
        try {
            $response = Http::withOptions([
                'proxy' => $proxy->getProxyUrl(),
                'timeout' => 5, // Timeout ngắn để kiểm tra nhanh
            ])->get('http://httpbin.org/ip');

            // Kiểm tra nếu request thành công
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
