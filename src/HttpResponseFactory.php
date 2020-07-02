<?php

namespace perf\HttpClient;

class HttpResponseFactory
{
    /**
     * @param int            $httpStatusCode
     * @param string[]       $headers
     * @param string         $bodyContent
     * @param {string:mixed} $transferDetails
     *
     * @return HttpResponse
     */
    public function create(
        int $httpStatusCode,
        array $headers,
        string $bodyContent,
        array $transferDetails = []
    ): HttpResponse {
        return new HttpResponse(
            $httpStatusCode,
            $headers,
            $bodyContent,
            $transferDetails
        );
    }
}
