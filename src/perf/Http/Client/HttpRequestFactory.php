<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpRequestFactory
{

    /**
     *
     *
     * @return HttpRequest
     */
    public function create()
    {
        return new HttpRequest();
    }
}
