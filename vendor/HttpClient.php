<?php

namespace Isystems\Vendor;

class HttpClient {
    public static function detectHttpClientHandler() {
        $httpClient = function_exists('curl_init') ? new CurlHttpClient() : null;
        return $httpClient;
    }
}
