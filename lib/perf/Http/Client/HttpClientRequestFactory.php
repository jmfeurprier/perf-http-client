<?php

namespace perf\Http\Client;

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
