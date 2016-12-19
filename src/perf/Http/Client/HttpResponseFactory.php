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
     * @param {string:mixed} $transferDetails
     * @return HttpResponse
     */
    public function create($httpStatusCode, array $headers, $bodyContent, array $transferDetails = array())
    {
        return new HttpResponse($httpStatusCode, $headers, $bodyContent, $transferDetails);
    }
}
