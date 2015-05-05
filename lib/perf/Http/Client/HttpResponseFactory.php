<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpResponseFactory
{

    /**
     *
     *
     * @param int $httpStatusCode
     * @param string[] $headers
     * @param string $bodyContent
     * @return HttpResponse
     */
    public function create($httpStatusCode, array $headers, $bodyContent)
    {
        return new HttpResponse($httpStatusCode, $headers, $bodyContent);
    }
}
