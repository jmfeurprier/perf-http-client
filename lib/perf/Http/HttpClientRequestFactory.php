<?php

namespace perf\Http;

/**
 *
 *
 */
class HttpClientRequestFactory
{

    /**
     *
     *
     * @return HttpClientRequest
     */
    public function create()
    {
        return new HttpClientRequest();
    }
}
