<?php

namespace perf\Http;

/**
 *
 *
 */
class HttpClientResponseFactory
{

    /**
     *
     *
     * @param string $url
     * @param int $httpStatus
     * @param string $content
     * @return HttpClientResponse
     */
    public function create($url, $httpStatus, $content)
    {
        return new HttpClientResponse($url, $httpStatus, $content);
    }
}
