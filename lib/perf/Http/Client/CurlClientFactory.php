<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class CurlClientFactory
{

    /**
     * Returns a new cURL client.
     *
     * @return CurlClient
     */
    public function create()
    {
        return new CurlClient();
    }
}
